<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Public\Address;
use App\Models\Public\BillingAddress;
use App\Models\Public\Cart;
use App\Models\Public\Order;
use App\Models\Public\ShippingAddress;
use Illuminate\Http\Request;

use Razorpay\Api\Api;

class PaymentController extends Controller
{

    public function index()
    {
        $order = Order::where([['customer_id', auth()->user()->id], ['order_status', false]])->first();
        if (!$order) return redirect()->back();

        $payableAmount = $order->is_full_payment ? $order->payable_amount : $order->advance_amount;

        $razorpay = $this->createRazorpayOrder($order, $payableAmount * 100);

        if ($razorpay) {

            $order->razorpay_order_id = $razorpay['order_id'];
            $order->save();
            return view('public.cart.payment', [
                'payableAmount' => $payableAmount,
                'order' => $order,
                'razorpay' => $razorpay,
                'customer' => Customer::find($order->customer_id)
            ]);
        }
    }

    public function callBack(Request $request)
    {
        $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

        if (!$order) {
            return response()->json(['error' => 'No Order Found'], 404);
        }

        $razorpaySecret = env('RAZORPAY_KEY');
        $dataToSign = $order->razorpay_order_id . '|' . $request->razorpay_payment_id;
        $generatedSignature = hash_hmac('sha256', $dataToSign, $razorpaySecret);

        if ($generatedSignature !== $request->razorpay_signature) {
            return response()->json(['error' => 'Signature mismatch'], 400);
        }


        $paid = $order->is_full_payment ? $order->payable_amount : $order->advance_amount;
        $order->order_date = now();
        $lo = Order::where('order_status', true)->count();
        $order->order_id = $this->getOrderId($lo + 1);
        $order->balance_amount = $order->pay_later_amount;
        $order->paid_amount =  $paid;
        $order->order_status = true;
        $order->save();


        $this->clearCart($order->customer_id);

        $this->insertAddress($order);

        Payment::create([
            'order_id' => $order->id,
            'paid' =>  $paid,
            'balance' => $order->is_full_payment ? 0 : $order->pay_later_amount,
            'payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
            'payment_mode' => 'Razorpay',
            'payment_remarks' => 'Initial Payment'
        ]);

        return redirect()->route('public.checkout.order.success', ['order_id' => $order->id]);
    }

    private function insertAddress(Order $order)
    {

        $address = Address::where('id', $order->address_id_for_billing)
            ->select('name', 'phone', 'address', 'address_2', 'land_mark', 'city', 'state', 'pincode')
            ->first()
            ->toArray();

        $shippingAddress = Address::where('id', $order->address_id_for_shipping)
            ->select('name', 'phone', 'address', 'address_2', 'google_map_address')
            ->first()
            ->toArray();


        ShippingAddress::create([...$shippingAddress, 'order_id' => $order->id]);
        BillingAddress::create([...$address, 'order_id' => $order->id]);
    }

    private function clearCart($id)
    {
        $cart = Cart::where([['customer_id', $id], ['status', false]])->first();

        if ($cart) {
            $cart->status = true;
            $cart->save();
        }
    }

    private function getOrderId($order_id)
    {
        if ($order_id < 10) {
            return 'SG-' . time() . '-' . sprintf('%03d', $order_id);
        } elseif ($order_id < 100) {
            return 'SG-' . time() . '-' . sprintf('%03d', $order_id);
        } else {
            return 'SG-' . time() . '-' . $order_id;
        }
    }

    private function createRazorpayOrder($order, $payableAmount)
    {
        try {

            $api = new Api(env('RAZORPAY_ID'), env('RAZORPAY_KEY'));


            $a = $api->order->create([
                'receipt' => "9",
                'amount' => $payableAmount,
                'currency' => 'INR',
                'notes' => [
                    'is_full_payment' => $order->is_full_payment ? 'YES' : 'NO',
                    'customer_id' => $order->customer_id
                ]
            ]);


            // var_dump($a);

            return [
                'order_id' => $a->id,
                'amount' => $a->amount,
                'currency' => $a->currency,
                'receipt' => $a->receipt,
            ];


            // $is_full_payment = $a->notes['Is_Full_Payment'];
        } catch (\Razorpay\Api\Errors\BadRequestError $e) {
            // Handle specific Razorpay errors
            // echo 'Bad Request Error: ' . $e->getMessage();

            return 0;
        } catch (\Razorpay\Api\Errors\ServerError $e) {
            // Handle server errors
            echo 'Server Error: ' . $e->getMessage();

            return 0;
        } catch (\Exception $e) {
            // Handle any other generic errors
            echo 'Error: ' . $e->getMessage();

            return 0;
        }
    }
}
