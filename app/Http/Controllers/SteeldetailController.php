<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Division;
use App\Models\Steeldetail;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SteeldetailController extends Controller
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
        $categories = Category::where('status', 1)->get();
        $subcategories = Subcategory::where('status', 1)->get();
        $divisions = Division::where('status', 1)->get();
        if ($request->ajax()) $this->getSteeldetail($request);
        return view('steel-detail.index', ['categories' => $categories, 'subcategories' => $subcategories, 'divisions' => $divisions]);
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
        $validated = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'nullable',
            'division_id' => 'nullable',
            'dimension' => 'nullable',
            'material' => 'nullable',
            'thickness' => 'nullable',
            'weight' => 'required',
        ]);

        $create = Steeldetail::create($validated);
        if ($create) return redirect()->back();
        else return response()->json(['message', 'Failed to add steel detail', 'status' => 'error', 'title' => 'Failed!'], 450);
        // if ($create) return response()->json(['message' => 'Steel detail Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        // else return response()->json(['message', 'Failed to add steel detail', 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Steeldetail $steeldetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Steeldetail $steeldetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Steeldetail $steeldetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Steeldetail $steeldetail)
    {
        //
    }

    public function getSteeldetail($request)
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
        $totalRecords = Steeldetail::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Steeldetail::select('count(*) as allcount')
            ->join('categories', 'categories.id', 'steeldetails.category_id')
            ->leftjoin('subcategories', 'subcategories.id', 'steeldetails.subcategory_id')
            ->leftjoin('divisions', 'divisions.id', 'steeldetails.division_id')
            ->count();
        // Fetch records
        $records = Steeldetail::join('categories', 'categories.id', 'steeldetails.category_id')
            ->leftjoin('subcategories', 'subcategories.id', 'steeldetails.subcategory_id')
            ->leftjoin('divisions', 'divisions.id', 'steeldetails.division_id')
            ->select('steeldetails.*', 'categories.category_name', 'subcategories.subcategory_name', 'divisions.division_name')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;
            $product_fields = '<div class="d-flex align-items-center gap-3">
                <span class="d-flex flex-column text-muted">
                   <span class="text-gray-800 text-hover-primary fw-bold"><span>Category : </span>' . $record->category_name . '</span>';
            if ($record->subcategory_name)  $product_fields .=  '<span class="text-gray-800 text-hover-primary fw-bold"><span>Subcategory : </span>' . $record->subcategory_name . '</span>';
            if ($record->division_name)  $product_fields .=  ' <span class="text-gray-800 text-hover-primary fw-bold  "><span>Division : </span>' . $record->division_name . '</span>';
            $product_fields .= ' </span>
            </div>';

            $steeldetails = '<div class="d-flex align-items-center gap-3">
                <span class="d-flex flex-column text-muted">';
            if ($record->dimension)  $steeldetails .=  '<span class="text-gray-800 text-hover-primary fw-bold"><span>Dimension : </span>' . $record->dimension . '</span>';
            if ($record->material)  $steeldetails .=  ' <span class="text-gray-800 text-hover-primary fw-bold  "><span>Material : </span>' . $record->material . '</span>';
            if ($record->thickness)  $steeldetails .=  ' <span class="text-gray-800 text-hover-primary fw-bold  "><span>Thickness : </span>' . $record->thickness . ' MM</span>';
            if ($record->weight)  $steeldetails .=  '  <span class="text-gray-800 text-hover-primary fw-bold"><span>Weight : </span>' . $record->weight . ' Kg</span>';
            $steeldetails .= ' </span>
            </div>';



            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "product_fields" => $product_fields,
                "steeldetails" => $steeldetails,
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
