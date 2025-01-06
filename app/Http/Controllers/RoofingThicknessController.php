<?php

namespace App\Http\Controllers;

use App\Models\RoofingThickness;
use Illuminate\Http\Request;

class RoofingThicknessController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getRoofingThickness($request);
        return view('console.roofing-thickness.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'thickness' => 'required',
            'formula_value' => 'required'
        ]);

        $create = RoofingThickness::create($validated);
        if ($create) return response()->json(['message' => 'Thickness ' . $request->color . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Thickness ' . $request->color, 'status' => 'error', 'title' => 'Failed!'], 450);
    }


    public function edit(RoofingThickness $roofing_thickness)
    {
        return response()->json(['message' => 'success', 'roofing' => $roofing_thickness], 200);
    }

    public function update(Request $request, RoofingThickness $roofing_thickness)
    {

        $validated = $request->validate([
            'thickness' => 'required',
            'formula_value' => 'required'
        ]);


        $updated = $roofing_thickness->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Thickness ' . $roofing_thickness->thickness . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update thickness ' . $roofing_thickness->thickness, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    public function destroy(RoofingThickness $roofing_thickness)
    {
        if ($roofing_thickness->delete()) {
            return response()->json(['message' => 'Thickness ' . $roofing_thickness->color . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete Thickness ' . $roofing_thickness->color, 'status' => 'error', 'title' => 'Failed!'], 200);
    }



    public function getRoofingThickness($request)
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
        $totalRecords = RoofingThickness::select('count(*) as allcount')->count();
        $totalRecordswithFilter = RoofingThickness::select('count(*) as allcount')
            ->count();
        // Fetch records
        $records = RoofingThickness::select('roofing_thicknesses.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $thickness = '<div class="d-flex align-items-center gap-3">
                         <span class="d-flex flex-column text-muted">
                             <span class="text-gray-800 text-hover-primary fw-bold">' . $record->thickness . '</span>
                         </span>
                     </div>';


            $data_arr[] = array(
                "id" => $id,
                "thickness" => $thickness,
                "formula_value" => $record->formula_value,
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
