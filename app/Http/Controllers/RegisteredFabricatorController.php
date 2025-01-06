<?php

namespace App\Http\Controllers;

use App\Models\Fabircator;
use App\Models\RegisteredFabricator;
use Illuminate\Http\Request;

class RegisteredFabricatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->id != 1) {
                return abort(404);
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getProducts($request);
        return view('registered-fabricator.index');
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
    public function show(RegisteredFabricator $registeredFabricator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegisteredFabricator $registeredFabricator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegisteredFabricator $registeredFabricator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fabircator $registeredFabricator)
    {
        if ($registeredFabricator->delete()) {
            return response()->json(['message' => 'Fabricator Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete Fabricator', 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getProducts($request)
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
        $totalRecords = Fabircator::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Fabircator::select('count(*) as allcount')
            ->where('company_name', 'like', '%' . $searchValue . '%')
            ->orWhere('phone', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = RegisteredFabricator::where('company_name', 'like', '%' . $searchValue . '%')
            ->orWhere('phone', 'like', '%' . $searchValue . '%')
            ->select('fabricators.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;
            $product_fields = '<div class="d-flex align-items-center gap-3">
                <span class="d-flex flex-column text-muted">
                   <span class="text-gray-800 text-hover-primary fw-bold"><span>Category : </span>' . $record->company_name . '</span>';
            if ($record->subcategory_name)  $product_fields .=  '<span class="text-gray-800 text-hover-primary fw-bold"><span>Subcategory : </span>' . $record->subcategory_name . '</span>';
            if ($record->division_name)  $product_fields .=  ' <span class="text-gray-800 text-hover-primary fw-bold  "><span>Division : </span>' . $record->division_name . '</span>';
            $product_fields .= ' </span>
            </div>';
            $product_image = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/public/storage/$record->product_image") . '" />
                        </span>
                    </div>';

            $product_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->product_name . '</span>
                        </span>
                    </div>';


            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "product_fields" => $product_fields,
                "product_image" => $product_image,
                "product_name" => $product_name,
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
