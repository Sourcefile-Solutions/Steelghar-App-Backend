<?php

namespace App\Http\Controllers;

use App\Models\ExpertAdvice;
use Illuminate\Http\Request;

class ExpertAdviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getExperts($request);
        return view('expert-advice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpertAdvice $expertAdvice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpertAdvice $expertAdvice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpertAdvice $expertAdvice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpertAdvice $id)
    {
        if ($id->delete()) {
            return response()->json(['message' => 'Expert advice ' . $id->name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete expert advice ' . $id->name, 'status' => 'error', 'title' => 'Failed!'], 200);
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

            $name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->name . '</span>
                        </span>
                    </div>';

            $email = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->email . '</span>
                        </span>
                    </div>';

            $phone = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->phone . '</span>
                        </span>
                    </div>';

            $message = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->message . '</span>
                        </span>
                    </div>';


            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "message" => $message,
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
