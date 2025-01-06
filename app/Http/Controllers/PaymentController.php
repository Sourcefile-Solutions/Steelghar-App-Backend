<?php

namespace App\Http\Controllers;


use App\Models\Payment;
use App\Models\Public\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{



    public function index(Request $request)
    {
        if ($request->ajax()) $this->getPayments($request);
        return view('payment.index');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'paid' => 'required|string',
            'payment_remarks' => 'nullable|string|max:250',
            'payment_mode' => 'required|string'
        ]);


        $order = Order::find($request->id);

        if (!$order) return response()->json(['status' => 'error', 'message' => 'Order Not Found']);

        if ($request->paid > str_replace(',', '', $order->balance_payment)) {
            return response()->json(['status' => 'error', 'message' => 'Paid Amount should be below or equal to balance amount']);
        }


        $validated['paid'] = number_format((float)$validated['paid'], 2, '.', '');

        $balance = str_replace(',', '', $order->balance_payment) - $validated['paid'];

        $validated['order_id'] = $order->id;
        $validated['payment_id'] = now()->timestamp;


        $validated['balance'] = number_format((float)($balance), 2, '.', '');
        $order->balance_payment = $balance;


        $created = Payment::create($validated);

        if ($created) {
            $order->save();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'failed to add payment']);
    }

    public function getPayments(Request $request)
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
        $totalRecords = Payment::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Payment::select('count(*) as allcount')
            ->where('order_id', 'like', '%' . $searchValue . '%')
            ->count();
        $records = Payment::join('orders', 'orders.id', 'payments.order_id')->where('orders.order_id', 'like', '%' . $searchValue . '%')
            ->select('payments.*', 'orders.order_id')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;




            $record->is_refund ? $is_refund = "<span class='badge badge-danger'>YES</span>" : $is_refund = "<span class='badge badge-success'>NO</span>";

            $data_arr[] = array(
                "id" => $id,
                "order_id" => $record->order_id,
                "is_refund" => $is_refund,
                "paid" => $record->paid,
                "balance" => $record->balance,
                "payment_id" =>  $record->payment_id,
                "payment_mode" => $record->payment_mode,
                "remarks" => $record->remarks,
                "date" => $record->created_at->format('d M Y'),
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
