<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\DeliveryAddress;
use App\Models\Public\Order;

use App\Models\Payment;
use App\Models\Public\BillingAddress;
use App\Models\Public\OrderItem;
use App\Models\Public\OrderStatus;
use App\Models\Public\ShippingAddress;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\AppTrait;

class OrderController extends Controller
{

    use AppTrait;


    public function index(Request $request)
    {
        if ($request->ajax()) $this->getOrders($request);
        return view('console.order.index');
    }

    public function show(Order $order)
    {
        // return $order;

        $customer = Customer::find($order->customer_id);


        $shippingAddress = ShippingAddress::where('order_id', $order->id)->first();
        $billingAddress = BillingAddress::where('order_id', $order->id)->first();


        $statuses = OrderStatus::where('order_id', $order->id)->select('id', 'status', 'created_at')->get();

        $payments = Payment::where('order_id', $order->id)->latest()->get();

        $items = OrderItem::where('order_id', $order->id)->latest()->get();

        if (count($statuses)) $dropdowns = $this->getDropdowns($statuses[count($statuses) - 1]->status);
        else $dropdowns = [];


        return view('console.order.show', [
            'order' => $order,
            'customer' => $customer,
            'shippingAddress' => $shippingAddress,
            'billingAddress' => $billingAddress,
            'statuses' => $statuses,
            'payments' => $payments,
            'items' => $items,
            'dropdowns' => $dropdowns
        ]);
    }

    protected function getDropdowns($current_status)
    {

        $status = match ($current_status) {
            'ORDER CONFIRMED' => ['MATERIAL LOADED', 'INVOICE GENERATED', 'PAYMENT RECIVED', 'ORDER SHIPPED', 'GOODS-IN-TRANSIT', 'MATERIAL DELIVERED'],
            'MATERIAL LOADED' => ['INVOICE GENERATED', 'PAYMENT RECIVED', 'ORDER SHIPPED', 'GOODS-IN-TRANSIT', 'MATERIAL DELIVERED'],
            'INVOICE GENERATED' => ['PAYMENT RECIVED', 'ORDER SHIPPED', 'GOODS-IN-TRANSIT', 'MATERIAL DELIVERED'],
            'PAYMENT RECIVED' => ['ORDER SHIPPED', 'GOODS-IN-TRANSIT', 'MATERIAL DELIVERED'],
            'ORDER SHIPPED' => ['GOODS-IN-TRANSIT', 'MATERIAL DELIVERED'],
            'GOODS-IN-TRANSIT' => ['MATERIAL DELIVERED'],
            'MATERIAL DELIVERED' => [],
            'CANCELD' => ['REFUND INITIATED', 'REFUND COMPLETED'],
            'ORDER REJECTED' => ['REFUND INITIATED', 'REFUND COMPLETED'],
            'REFUND INITIATED' => ['REFUND COMPLETED'],
            'REFUND INITIATED' => [],
            default => [],
        };

        return $status;
    }

    public function accept(Order $order)
    {
        $orderStatuses = Orderstatus::where('order_id', $order->id)->get();

        if (!count($orderStatuses)) {
            $order->current_status = 'ORDER CONFIRMED';
            $order->save();
            Orderstatus::create(['order_id' => $order->id, 'status' => 'ORDER CONFIRMED']);
            $data = [
                'title' => 'Order Confirmed 👍',
                'message' => 'Your order #' . $order->order_id . ' Confirmed!',
                'image' => ''
            ];
            $this->sendNotifications([$order->user_id], $data);
            return response()->json(['status' => 'success', 'message' => 'Order Confirmed Successfully!', 'title' => 'Confirmed']);
        }
    }

    public function reject(Order $order)
    {
        $orderStatuses = Orderstatus::where('order_id', $order->id)->get();

        if (!count($orderStatuses)) {
            $order->current_status = 'ORDER REJECTED';
            $order->is_rejected = true;
            $order->save();
            Orderstatus::create(['order_id' => $order->id, 'status' => 'ORDER REJECTED']);
            $data = [
                'title' => 'Order Rejected 😔',
                'message' => 'Your order #' . $order->order_id . ' Rejected!, If you done any payment will refund shortly',
                'image' => ''
            ];
            $this->sendNotifications([$order->customer_id], $data);
            return response()->json(['status' => 'success', 'message' => 'Order Rejected Successfully!', 'title' => 'Rejected']);
        }
    }

    public function updateStatus(Order $order, Request $request)
    {
        $validated = $request->validate(['status' => 'required']);
        $already = Orderstatus::where([['status', $request->status], ['order_id', $order->id]])->first();

        if (!$already) {
            $order->current_status = $request->status;
            $order->save();
            Orderstatus::create(['order_id' => $order->id, 'status' => $request->status]);
            $this->sendStatusNotification($order, $request->status);
            return redirect()->back();
        }
        return redirect()->back();
    }

    protected function sendStatusNotification($order, $status)
    {

        $title = '';
        $message = '';

        if (!$status) return false;

        else if ($status == 'MATERIAL LOADED') {
            $title = 'Material Loaded';
            $message = 'Your order #' . $order->order_id . ' Material Loaded';
        } else if ($status == 'INVOICE GENERATED') {
            $title = 'Invoice Generated';
            $message = 'Your order #' . $order->order_id . ' Invoice Generated';
        } else if ($status == 'PAYMENT RECIVED') {
            $title = 'Payment Recived';
            $message = 'Your order #' . $order->order_id . ' Payment Recived';
        } else if ($status == 'ORDER SHIPPED') {
            $title = 'Order Shipped';
            $message = 'Your order #' . $order->order_id . ' Order Shipped';
        } else if ($status == 'GOODS-IN-TRANSIT') {
            $title = 'Goods In Transit';
            $message = 'Your order #' . $order->order_id . ' Goods In Transit';
        } else if ($status == 'MATERIAL DELIVERED') {
            $title = 'Material Delived';
            $message = 'Your order #' . $order->order_id . ' delivered !!!!!!!!!!';
        }

        if (!$title) return false;
        $data = [
            'title' => $title,
            'message' => $message,
            'image' => ''
        ];
        $this->sendNotifications([$order->customer_id], $data);
    }

    protected function getOrders($request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        $totalRecords = Order::where('order_status', true)->select('count(*) as allcount')->count();
        $totalRecordswithFilter = Order::where('order_status', true)->select('count(*) as allcount')
            ->where('order_id', 'like', '%' . $searchValue . '%')
            ->count();
        $records = Order::where('order_status', true)->where('order_id', 'like', '%' . $searchValue . '%')
            ->join('customers', 'customers.id', 'orders.customer_id')
            ->select('orders.*', 'name')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;




            // $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "order_id" => $record->order_id,
                "order_date" => $record->order_date,
                "name" => $record->name,
                "order_status" => $record->current_status,
                "payable_amount" => '₹' . $record->payable_amount,
                "action" => $id,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
        exit;
    }
}
