<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Orderitems;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function invoiceDownload(Order $order)
    {
        $customer = User::find($order->user_id);
        $address = Address::find($order->address_id);
        $orderItems = Orderitems::where('order_id', $order->id)->get();
        // return $orderItems;
        $pdf = Pdf::loadView('invoice.invoice-one', ['order' => $order, 'customer' => $customer, 'address' => $address, 'orderItems' => $orderItems]);

        // $pdf = Pdf::loadView('pdf.invoice', $data);
        return $pdf->download('invoice.pdf');
    }
}
