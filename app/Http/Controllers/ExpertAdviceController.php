<?php

namespace App\Http\Controllers;

use App\Models\Public\ExpertAdvice;
use Illuminate\Http\Request;

class ExpertAdviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getExperts($request);
        return view('console.expert-advice.index');
    }

    public function destroy(ExpertAdvice $expertAdvice)
    {
        if ($expertAdvice->delete()) {
            return response()->json(['message' => 'Expert advice ' . $expertAdvice->name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete expert advice ' . $expertAdvice->name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getExperts($request)
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
        $totalRecords = ExpertAdvice::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ExpertAdvice::select('count(*) as allcount')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('phone', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = ExpertAdvice::where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('phone', 'like', '%' . $searchValue . '%')
            ->select('expert_advice.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;





            $phone = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                          <p class="text-gray-800 text-hover-primary fw-bold">' . $record->name . '</p>
                         <p class="text-gray-800 text-hover-primary fw-bold">
                         <a href="mailto:' . $record->email . '">' . $record->email . '</a>
                         </p>
                            <p class="text-gray-800 text-hover-primary fw-bold">
                            <a href="tel:+91' . $record->phone . '">' . $record->phone . '</a>
                            </p>
                        </span>
                    </div>';

            $message = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->message . '</span>
                        </span>
                    </div>';


            $data_arr[] = array(
                "id" => $id,
                "phone" => $phone,
                "message" => $message,
                "created_at" => $record->created_at,
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
