<?php

namespace App\Http\Controllers;

use App\Models\RoofingColor;
use Illuminate\Http\Request;

class RoofingColorController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) $this->getRoofingColors($request);
        return view('console.roofing-color.index');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'color' => 'required',
            'status' => 'nullable'
        ]);

        $create = RoofingColor::create($validated);
        if ($create) return response()->json(['message' => 'Color ' . $request->color . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Color ' . $request->color, 'status' => 'error', 'title' => 'Failed!'], 450);
    }



    public function edit(RoofingColor $roofing_color)
    {
        return response()->json(['message' => 'success', 'roofing' => $roofing_color], 200);
    }

    public function update(Request $request, RoofingColor $roofing_color)
    {

        $validated = $request->validate([
            'color' => 'nullable',
            'status' => 'nullable'
        ]);


        $updated = $roofing_color->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Thickness ' . $roofing_color->color . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update thickness ' . $roofing_color->color, 'title' => 'Failed', 'status' => 'error'], 200);
    }



    public function destroy(RoofingColor $roofing_color)
    {
        if ($roofing_color->delete()) {
            return response()->json(['message' => 'Color Name ' . $roofing_color->color . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete Color Name ' . $roofing_color->color, 'status' => 'error', 'title' => 'Failed!'], 200);
    }


    public function getRoofingColors($request)
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
        $totalRecords = RoofingColor::select('count(*) as allcount')->count();
        $totalRecordswithFilter = RoofingColor::select('count(*) as allcount')
            ->count();
        // Fetch records
        $records = RoofingColor::select('roofing_colors.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $color = '<div class="d-flex align-items-center gap-3">
                         <span class="d-flex flex-column text-muted">
                             <span class="text-gray-800 text-hover-primary fw-bold">' . $record->color . '</span>
                         </span>
                     </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                // "thickness" => $thickness,
                // "weight" => $weight,
                "color" => $color,
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
