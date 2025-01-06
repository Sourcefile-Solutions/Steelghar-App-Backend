<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\Request;

class PincodeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getPincodes($request);
        return view('console.pincode.index');
    }


    public function store(Request $request)
    {
        $validated     = $request->validate([
            'state'    => 'required|string',
            'office_name'     => 'required|string',
            'office_type'     => 'required|string',
            'pincode'  => 'required|digits:6|unique:pincodes',
            'delivery_charge'   => 'required|numeric',
            'duration' => 'required|string',
            'division_name'     => 'required|string',
            'region_name'     => 'required|string',
            'circle_name'     => 'required|string',
            'telephone'     => 'nullable|string',
            'related_headoffice'     => 'required|string',
            'related_suboffice'     => 'required|string',
            'district'     => 'required|string',
            'taluk'     => 'required|string',
            'delivery_status'     => 'required|string',
        ]);

        $create = Pincode::create($validated);

        if ($create) return response()->json(['message' => 'Pincode ' . $request->pincode . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add pincode ' . $request->pincode, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pincode $pincode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pincode $pincode)
    {
        return response()->json(['message' => 'success', 'pincode' => $pincode], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pincode $pincode)
    {
        $validated = $request->validate([
            'state'    => 'required|string',
            'office_name'     => 'required|string',
            'office_type'     => 'required|string',
            'pincode'  => 'required|digits:6|unique:pincodes,pincode,' . $pincode->id,
            'delivery_charge'   => 'required|numeric',
            'duration' => 'required|string',
            'division_name'     => 'required|string',
            'region_name'     => 'required|string',
            'circle_name'     => 'required|string',
            'telephone'     => 'nullable|string',
            'related_headoffice'     => 'required|string',
            'related_suboffice'     => 'required|string',
            'district'     => 'required|string',
            'taluk'     => 'required|string',
            'delivery_status'     => 'required|string',
        ]);

        $updated = $pincode->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Pincode ' . $pincode->pincode . ' Updated successfully!', 'title' => 'Updated', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update pincode ' . $pincode->pincode, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pincode $pincode)
    {
        if ($pincode->delete()) {
            return response()->json(['message' => 'Pincode ' . $pincode->pincode . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete pincode ' . $pincode->pincode, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getPincodes($request)
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
        $totalRecords = Pincode::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Pincode::select('count(*) as allcount')
            ->where('pincode', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Pincode::where('pincode', 'like', '%' . $searchValue . '%')
            ->select('pincodes.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $pincode = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->pincode . '</span>
                        </span>
                    </div>';

            $post = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                        <span class="text-gray-800 text-hover-primary fw-bold">' . $record->office_name . '</span>
                        <span class="text-gray-800 text-hover-primary fw-bold">' . $record->office_type . '</span>
                        </span>
                    </div>';

            $del_status = $record->delivery_status ? $del_status = "<span class='badge badge-success'>Delivarable</span>" : $del_status = "<span class='badge badge-danger'>Not Delivarable</span>";

            $delivery = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->delivery_charge . '</span>
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $del_status . '</span>
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->duration . '</span>
                        </span>
                    </div>';

            $divisions = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->division_name . '</span>
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->region_name . '</span>
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->circle_name . '</span>
                        </span>
                    </div>';

            $offices = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->related_headoffice . '</span>
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->related_suboffice . '</span>
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->telephone . '</span>
                        </span>
                    </div>';

            $state = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->state . '</span>
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->district . '</span>
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->taluk . '</span>
                        </span>
                    </div>';

            $data_arr[] = array(
                "id" => $id,
                "pincode" => $pincode,
                "post" => $post,
                "delivery" => $delivery,
                "divisions" => $divisions,
                "offices" => $offices,
                "state" => $state,
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
