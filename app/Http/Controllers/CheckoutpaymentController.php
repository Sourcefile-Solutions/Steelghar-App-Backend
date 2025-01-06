<?php

namespace App\Http\Controllers;

use App\Models\CheckoutPayment;
use Illuminate\Http\Request;

class CheckoutPaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getCheckoutPayment($request);
        return view('console.checkout-payment.index');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'min_range' => 'nullable|string',
            'max_range' => 'nullable|string',
            'payment_percentage' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $create = CheckoutPayment::create($validated);

        if ($create) return response()->json(['message' => 'Payment Range ' . $request->min_range . ' To ' . $request->max_range . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add payment range ' . $request->min_range . ' To ' . $request->max_range, 'status' => 'error', 'title' => 'Failed!'], 450);
    }


    public function edit(CheckoutPayment $Checkoutpayment)
    {
        return response()->json(['message' => 'success', 'CheckoutPayment' => $Checkoutpayment], 200);
    }


    public function update(Request $request, CheckoutPayment $checkoutpayment)
    {
        $validated = $request->validate([
            'min_range' => 'nullable|string',
            'max_range' => 'nullable|string',
            'payment_percentage' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);


        $updated = $checkoutpayment->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Payment Range ' . $checkoutpayment->min_range . ' To ' . $checkoutpayment->max_range . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update Payment Range ' . $checkoutpayment->min_range . ' To ' . $checkoutpayment->max_range, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    public function destroy(CheckoutPayment $checkoutpayment)
    {
        if ($checkoutpayment->delete()) {
            return response()->json(['message' => 'Payment Range ' . $checkoutpayment->min_range . ' To ' . $checkoutpayment->max_range . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete Payment Range ' . $checkoutpayment->min_range . ' To ' . $checkoutpayment->max_range, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getCheckoutPayment($request)
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
        // Total records
        $totalRecords = CheckoutPayment::select('count(*) as allcount')->count();
        $totalRecordswithFilter = CheckoutPayment::select('count(*) as allcount')
            ->where('min_range', 'like', '%' . $searchValue . '%')
            ->orWhere('max_range', 'like', '%' . $searchValue . '%')
            ->orWhere('payment_percentage', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = CheckoutPayment::where('min_range', 'like', '%' . $searchValue . '%')
            ->orWhere('max_range', 'like', '%' . $searchValue . '%')
            ->orWhere('payment_percentage', 'like', '%' . $searchValue . '%')
            ->select('checkout_payments.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $min_range = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->min_range . '</span>
                        </span>
                    </div>';

            $max_range = '<div class="d-flex align-items-center gap-3">
                    <span class="d-flex flex-column text-muted">
                        <span class="text-gray-800 text-hover-primary fw-bold">' . $record->max_range . '</span>
                    </span>
                </div>';

            $payment_percentage = '<div class="d-flex align-items-center gap-3">
                <span class="d-flex flex-column text-muted">
                    <span class="text-gray-800 text-hover-primary fw-bold">' . $record->payment_percentage . '</span>
                </span>
            </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "min_range" => $min_range,
                "max_range" => $max_range,
                "payment_percentage" => $payment_percentage,
                "status" => $status,
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
