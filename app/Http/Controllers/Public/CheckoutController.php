<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Checkoutpayment;
use App\Models\DeliveryAddress;
use App\Models\MinimumCharge;

use App\Models\Public\Address;
use App\Models\Public\BillingAddress;
use App\Models\Public\Cart;
use App\Models\Public\Cartproduct as PublicCartproduct;
use App\Models\Public\Order as PublicOrder;
use App\Models\Public\OrderItem;
use App\Models\Public\ShippingAddress;
use App\Traits\CartTrait;


class CheckoutController extends Controller
{

    use CartTrait;






    public function index()
    {

        $userId = auth()->user()->id;


        $cart = Cart::where('customer_id', $userId)->where('status', false)->first();


        if (!$cart) {
            return view('public.cart.checkout', ['cart' => $cart]);
        }


        $cartProducts = PublicCartproduct::where('cart_id', $cart->id)->latest()->get();


        if ($cartProducts->isEmpty()) {
            return view('public.cart.checkout', ['cart' => $cart, 'cartProducts' => $cartProducts]);
        }


        $addresses = Address::where('customer_id', $userId)->whereNotNull('pincode')->latest()->get();


        $cartCalculationResult = $this->cartCalculation($cartProducts);


        $charges = MinimumCharge::all();
        $checkoutPayments = Checkoutpayment::where('status', true)->get();


        return view('public.cart.checkout', [
            'cart' => $cart,
            'cartProducts' => $cartCalculationResult[0],
            'addressess' => $addresses,
            'amountCalculation' => $cartCalculationResult[1],
            'charges' => $charges,
            'totalWeight' => $cartCalculationResult[1]['totalWeight'],
            'checkoutPayments' => $checkoutPayments,
            'gst_percentage' => 18,
        ]);
    }



    public function payment(Request $request)
    {

        $validated = $request->validate([
            'address_id_for_billing' => 'required|integer',
            'is_full_payment' => 'required|boolean',
            'google_map_address' => 'required|string',
            'total_km' => 'required|string',
            'delivery_name' => 'required|string',
            'delivery_phone' => 'required|digits:10',
            'address_line_1' => 'required|string|max:1000',
            'address_line_2' => 'nullable|string|max:1000'
        ]);

        $cart = Cart::where([['customer_id', auth()->user()->id], ['status', false]])->first();
        if (!$cart)  return response()->json(['status' => 'error', 'message' => 'cart not found', 'action' => 'home']);

        $cartProducts = PublicCartproduct::where('cart_id',  $cart->id)->get();

        $data =  $this->finalCalculation($cartProducts, $validated['total_km']);




        $shippingAddress = Address::create([
            'customer_id' => auth()->user()->id,
            'name' => $validated['delivery_name'],
            'phone' => $validated['delivery_phone'],
            'address' => $validated['address_line_1'],
            'address_2' => $validated['address_line_2'],
            'google_map_address' => $validated['google_map_address']
        ]);



        $order = PublicOrder::where([['customer_id', auth()->user()->id], ['order_status', false]])->first();

        if (!$order) $order = PublicOrder::create([
            'customer_id' => auth()->user()->id,
            'address_id_for_billing' => $validated['address_id_for_billing'],
            'address_id_for_shipping' => $shippingAddress->id,
            'total_km' => $validated['total_km'],
            'is_full_payment' => $validated['is_full_payment'],
            'sub_total' => $data[1]['subTotal'],
            'shipping_charge' => $data[1]['shippingCharge'],
            'handling_charge' => 0,
            'gst_charge' => $data[1]['gst'],
            'advance_amount' => $data[1]['payableAmount'],
            'pay_later_amount' => $data[1]['payLaterAmount'],
            'payable_amount' => $data[1]['grandTotal'],
            'total_weight' =>  $data[1]['total_weight'],
        ]);


        else {
            $order->address_id_for_billing = $validated['address_id_for_billing'];
            $order->address_id_for_shipping = $shippingAddress->id;
            $order->total_km = $validated['total_km'];
            $order->sub_total = $data[1]['subTotal'];
            $order->shipping_charge = $data[1]['shippingCharge'];
            $order->handling_charge = 0;
            $order->gst_charge = $data[1]['gst'];
            $order->advance_amount = $data[1]['payableAmount'];
            $order->pay_later_amount = $data[1]['payLaterAmount'];
            $order->payable_amount = $data[1]['grandTotal'];
            $order->total_weight = $data[1]['total_weight'];
            $order->is_full_payment = $validated['is_full_payment'];
            $order->save();
        }





        $this->handleOrderItems($data[0], $order->id);

        return response()->json(['status' => 'success', 'action' => 'cart-payment']);
    }







    protected function handleOrderItems($products, $orderId)
    {

        OrderItem::where('order_id', $orderId)->delete();
        $items = [];
        foreach ($products as $product) {
            $p = [
                'order_id' => $orderId,
                'product_id' => $product['product_id'],
                'category_id' => $product['category_id'],
                'product_name' => $product['product_name'],
                'product_image' => $product['product_image'],
                'sub_total' => $product['sub_total'],
            ];
            if ($product['category_id'] == 1) {
                $a = [
                    ...$p,
                    'brand_name' => $product['brand_name'],
                    'weight' => $product['weight'],
                    'length' => $product['length'],
                ];
                OrderItem::insert($a);
            } else if ($product['category_id'] == 2) {
                $a = [
                    ...$p,
                    'height' => $product['height'],
                    'length' => $product['length'],
                ];
                OrderItem::insert($a);
            } else if ($product['category_id'] == 3) {
                $a = [
                    ...$p,
                    'color' => $product['color'],
                    'thickness' => $product['thickness'],
                    'size' => $product['size'],
                    'no_of_sheet' => $product['no_of_sheet'],
                ];
                OrderItem::insert($a);
            } else {
                $a = [
                    ...$p,
                    'length' => $product['length'],
                    'thickness' => $product['thickness'],
                    'weight' => $product['weight'],
                ];
                OrderItem::insert($a);
            }
        }

        return 1;
    }



    public function checkoutSuccess($order_id)
    {
        $order = PublicOrder::where([['id', $order_id], ['customer_id', auth()->user()->id]])->first();
        if (!$order) return abort(404);
        $shippingAddress = ShippingAddress::where('order_id', $order->id)->first();
        $billingAddress = BillingAddress::where('order_id', $order->id)->first();

        return  view('public.cart.success', ['order' => $order, 'shippingAddress' => $shippingAddress, 'billingAddress' => $billingAddress]);
    }
}
