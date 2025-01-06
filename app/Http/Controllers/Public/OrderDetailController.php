<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Address;
use App\Models\Order;
use App\Models\Orderitems;
use App\Models\Orderstatus;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{


    public function orderTracking($order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $orderitems = Orderitems::where('order_id', $order_id)->get();
        $address = Address::where('id', $order->address_id)->first();
        $orderstatus = Orderstatus::where('order_id', $order_id)->latest()->first();
        $statustime = Orderstatus::where('order_id', $order_id)->get();
        return view('ordertracking', ['order' => $order, 'orderitems' => $orderitems, 'address' => $address, 'orderstatus' => $orderstatus, 'statustime' => $statustime]);
    }

    public function invoiceDownload(Order $order)
    {
        $customer = User::find($order->user_id);
        $address = Address::find($order->address_id);
        $orderItems = Orderitems::where('order_id', $order->id)->get();
        $pdf = Pdf::loadView('invoice', ['order' => $order, 'customer' => $customer, 'address' => $address, 'orderItems' => $orderItems]);
        return $pdf->download('invoice.pdf');
    }
}
