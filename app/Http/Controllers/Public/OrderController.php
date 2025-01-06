<?php

namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use App\Models\Public\BillingAddress;
use App\Models\Public\Order;
use App\Models\Public\OrderItem;
use App\Models\Public\OrderStatus;
use App\Models\Public\ShippingAddress;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function index()
    {
        $orders = Order::where([['customer_id', auth()->user()->id], ['order_status', true]])->latest()->get();
        return view('public.order.index', ['orders' => $orders]);
    }


    public function show($id)
    {
        $order = Order::where([['order_id', $id], ['customer_id', auth()->user()->id], ['order_status', true]])->first();

        if (!$order) return abort(404);

        $orderStatus = OrderStatus::where('order_id', $order->id)->latest()->get();

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        $billingAddress = BillingAddress::where('order_id', $order->id)->first();

        $shippingAddress = ShippingAddress::where('order_id', $order->id)->first();

        // return $orderStatus;

        return view('public.order.show', [
            'order' => $order,
            'orderStatus' => $orderStatus,
            'orderItems' => $orderItems,
            'billingAddress' => $billingAddress,
            'shippingAddress' => $shippingAddress
        ]);
    }

    public function orderSuccess()
    {
        return view('order-success');
    }

    // public function orderhistory()
    // {
    //     $orderHistory = Order::where('user_id', auth()->user()->id)->orderBy('order_date', 'desc')->get();
    //     return view('orderhistory', ['orderHistory' => $orderHistory]);
    // }
}
