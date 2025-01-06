<?php

namespace App\Traits;

use App\Models\Brand;
use App\Models\CategoryPrice;
use App\Models\CheckoutPayment;
use App\Models\MinimumCharge;
use App\Models\ProductAttribute;
use App\Models\Tmtdetail;

trait CartTrait
{


    public function finalCalculation($products, $total_km = 0)
    {
        $a = [];
        foreach ($products as $product) {
            $b = match ($product->product->category_id) {
                1 => $this->tmtProducts($product),
                2 => $this->meshProducts($product),
                3 => $this->roofProducts($product),
                default => $this->otherProducts($product),
            };
            array_push($a, $b);
        }


        return [$a, $this->checkoutCalculation($a, $total_km)];
    }

    public function checkoutCalculation($products, $total_km)
    {
        $subTotal = 0;
        $totalWeight = 0;
        foreach ($products as $p) {

            // return $p;
            $subTotal += floatval(str_replace(',', '', $p['sub_total']));
            if (isset($p['weight'])) {
                $totalWeight +=  (float) str_replace(',', '', $p['weight']);
            }
        }
        $shippingCharge = $this->calculateDeliveryCharge($total_km, $totalWeight);
        $finalAmounts = $this->calculateFinalPayments($subTotal, $shippingCharge);
        return [...$finalAmounts, 'shippingCharge' => $shippingCharge, 'total_weight' => $totalWeight];
    }




    protected function calculateFinalPayments($totalAmount, $shippingCharge, $gstPercentage = 18)
    {
        // Fetch active payment slabs from the database
        $checkoutPayments = Checkoutpayment::where('status', true)->get()->toArray(); // Convert to array for easier filtering

        // Filter payment groups based on totalAmount
        $paymentGroup = array_filter($checkoutPayments, function ($charge) use ($totalAmount) {
            return $totalAmount <= $charge['max_range'] && $totalAmount >= $charge['min_range'];
        });

        // Check if any valid payment slab is found
        if (empty($paymentGroup)) {
            throw new Exception('No valid payment slab found for the given totalAmount.');
        }

        // Get the first matching slab
        $slab = array_values($paymentGroup)[0];

        // Calculate GST and totals
        $gst = ceil($gstPercentage ? (($totalAmount * $gstPercentage) / 100) : 0);
        $grandTotal = round($totalAmount + $gst + $shippingCharge); // Always add GST and shipping
        $payableAmount = round(($grandTotal * $slab['payment_percentage']) / 100);
        $payLaterAmount = $grandTotal - $payableAmount;

        // Format amounts for output
        return [
            'subTotal' => $totalAmount,
            'gst' => $gst,
            'gstPercentage' => $gstPercentage,
            'grandTotal' => $grandTotal,
            'payableAmount' => $payableAmount,
            'payLaterAmount' => $payLaterAmount,
        ];
    }

    protected function formatAmount($amount)
    {
        return number_format($amount, 2, '.', ',');
    }

    protected function calculateDeliveryCharge($totalKm, $totalWeight)
    {
        $minimumCharge = 0;

        // Retrieve charges from the database
        $charges = MinimumCharge::all();

        // Filter charges based on weight
        $weightFilteredCharges = $charges->filter(function ($charge) use ($totalWeight) {
            return $totalWeight >= $charge->from_kg && $totalWeight <= $charge->to_kg;
        });

        // Check if any applicable charges are found
        if ($weightFilteredCharges->isEmpty()) {
            throw new Exception('No applicable charges found for the given weight.');
        }

        $firstCharge = $weightFilteredCharges->first();

        // Calculate minimum charge based on the first charge's ID
        if ($firstCharge->id === 1) {
            if ($totalKm <= $firstCharge->to_km) {
                $minimumCharge = (float) $firstCharge->minimum_charge;
            } else {
                $additionalKm = $totalKm - $firstCharge->to_km;
                $additionalCharge = $additionalKm * $firstCharge->additional_charge;
                $minimumCharge = (float) $firstCharge->minimum_charge + $additionalCharge;
            }
        } else {
            // Filter charges based on distance
            $finalMatchingCharges = $weightFilteredCharges->filter(function ($charge) use ($totalKm) {
                return $totalKm >= $charge->from_km && $totalKm <= $charge->to_km;
            });

            // Check if any applicable charges are found for the distance
            if ($finalMatchingCharges->isEmpty()) {
                throw new Exception('No applicable charges found for the given distance.');
            }

            $last = $finalMatchingCharges->first(function ($charge) use ($totalKm) {
                return $charge->to_km >= $totalKm && $charge->from_km <= $totalKm;
            });

            if ($last) {
                $minimumCharge = (float) $last->minimum_charge;
            } else {
                throw new Exception('No valid charge found for the specified distance.');
            }
        }

        return round($minimumCharge);
    }

    public function cartCalculation($products)
    {
        $a = [];
        foreach ($products as $product) {
            $b = match ($product->product->category_id) {
                1 => $this->tmtProducts($product),
                2 => $this->meshProducts($product),
                3 => $this->roofProducts($product),
                default => $this->otherProducts($product),
            };
            if ($b)  array_push($a, $b);
        }
        return [$a, $this->amountCalculation($a)];
    }


    protected function tmtProducts($product)
    {
        $brand = Brand::find($product->brand_id);
        $tmt_details = Tmtdetail::find($product->product->thickness_id);

        if (!$brand || !$tmt_details) return 0;

        return [
            'product_id' => $product->product->id,
            'product_name' => $product->product->product_name,
            'product_image' => $product->product->product_image ? asset('storage/' . $product->product->product_image) : asset('no-image.png'),
            'category_id' => $product->product->category_id,
            'brand_name' => $brand->brand_name,
            'weight' =>  number_format(($tmt_details->weight * $product->length), 2),
            'length' => number_format($product->length, 2),
            'sub_total' => number_format(($brand->price * ($tmt_details->weight * $product->length)), 2),
            'cart_product_id' => $product->id,
            'tmtWeight'=>$tmt_details->weight
        ];
    }

    protected function meshProducts($product)
    {

        $attribute = ProductAttribute::find($product->product_attribute_id);


        $category = CategoryPrice::where('category_id', $product->product->category_id)->first();
        if (!$attribute || !$category) return 0;

        return [
            'product_id' => $product->product->id,
            'product_name' => $product->product->product_name,
            'product_image' => $product->product->product_image ? asset('storage/' . $product->product->product_image) : asset('no-image.png'),
            'category_id' => $product->product->category_id,
            'height' =>  number_format($attribute->height, 2),
            'length' =>  number_format($product->length, 2),
            'sub_total' => number_format((($category->price + $attribute->price) * $attribute->height * $product->length), 2),
            'weight' => number_format(($product->length * 1.3), 2),
            'cart_product_id' => $product->id,
        ];
    }

    protected function roofProducts($product)
    {
        $attribute = ProductAttribute::join('roofing_thicknesses', 'roofing_thicknesses.id', 'product_attributes.thickness')
            ->where('product_attributes.id', $product->product_attribute_id)
            ->select('product_attributes.id', 'roofing_thicknesses.thickness',  'price', 'formula_value')->first();

        $category = CategoryPrice::where('category_id', $product->product->category_id)->first();

        if (!$attribute || !$category) return 0;

        return [
            'product_id' => $product->product->id,
            'product_name' => $product->product->product_name,
            'product_image' => $product->product->product_image ? asset('storage/' . $product->product->product_image) : asset('no-image.png'),
            'category_id' => $product->product->category_id,
            'color' => $product->color,
            'thickness' =>  number_format($attribute->thickness, 2),
            'size' => number_format($product->size, 2),
            'no_of_sheet' =>  number_format($product->no_of_sheet, 2),
            'sub_total' => number_format(($attribute->formula_value * ($category->price + $attribute->price) * $product->no_of_sheet * $product->size), 2),
            'cart_product_id' => $product->id,
            'weight' => number_format(($product->size * 1.3 * $product->no_of_sheet), 2),
        ];
    }

    protected function otherProducts($product)
    {
        $attribute = ProductAttribute::find($product->product_attribute_id);

        $category = CategoryPrice::where('category_id', $product->product->category_id)->first();

        if (!$attribute || !$category) return 0;


        return [
            'product_id' => $product->product->id,
            'product_name' => $product->product->product_name,
            'product_image' => $product->product->product_image ? asset('storage/' . $product->product->product_image) : asset('no-image.png'),
            'category_id' => $product->product->category_id,
            'thickness' =>   number_format($attribute->thickness + 5, 2),
            'weight' =>    number_format(($attribute->weight * $product->length), 2),
            'length' =>  number_format($product->length,  2),
            'sub_total' => number_format((($category->price + $attribute->price) * ($attribute->weight * $product->length)), 2),
            'cart_product_id' => $product->id,
        ];
    }


    public function amountCalculation($products)
    {
        $t = 0;
        $totalWeight = 0;
        foreach ($products as $p) {

            info($p);
            $t += floatval(str_replace(',', '', $p['sub_total']));
            if (isset($p['weight'])) {
                $totalWeight +=  (float) str_replace(',', '', $p['weight']);
            }
        }

        $grandTotal = round($t + ($t * 18 / 100));
        $apc = $this->advancePaymentCalculation(round($t + ($t * 18 / 100)));
        return [
            'total' => number_format($t, 2),
            'shippingCharge' => number_format(0.00, 2),
            'handlingCharge' => number_format(0.00, 2),
            'gst' =>   number_format(($t * 18 / 100), 2),
            'grandTotal' => number_format($grandTotal, 2),
            'payAdvance' => number_format($apc[0], 2),
            'payLater' =>  number_format($apc[1], 2),
            'totalWeight' => $totalWeight
        ];
    }

    protected function advancePaymentCalculation($grandTotal)
    {


        $slab = CheckoutPayment::where('min_range', '<=', $grandTotal)
            ->where('max_range', '>=', $grandTotal)
            ->first();

        if ($slab) $per = $slab->payment_percentage;
        else $per = 100;
        $payAdvance = $grandTotal * $per / 100;
        $payLater = $grandTotal - $payAdvance;
        return [$payAdvance, $payLater];
    }
}
