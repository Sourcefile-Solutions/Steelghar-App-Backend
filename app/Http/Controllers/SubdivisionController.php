<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dimention;
use App\Models\Division;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use App\Models\Subdivision;
use Illuminate\Http\Request;

class SubdivisionController extends Controller
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
        if ($request->ajax()) $this->getSubdivisions($request);
        $categories = Category::where('status', 1)->get();
        $subcategories = Subcategory::where('status', 1)->get();
        $divisions = Division::where('status', 1)->get();
        return view('subdivision.index', ['categories' => $categories, 'subcategories' => $subcategories, 'divisions' => $divisions]);
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
            'subcategory_id' => 'required',
            'division_id' => 'required',
            'subdivision_name' => 'required|string|max:25|unique:subdivisions',
            'status' => 'required|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['subdivision_name'], '-');

        $create = Subdivision::create($validated);

        if ($create) return response()->json(['message' => 'Subdivision ' . $request->subdivision_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Subdivision ' . $request->subdivision_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subdivision $subdivision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subdivision $subdivision)
    {
        return response()->json(['message' => 'success', 'subdivision' => $subdivision], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subdivision $subdivision)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'division_id' => 'required',
            'subdivision_name' => 'required|string|max:25|unique:subdivisions,subdivision_name,' . $subdivision->id,
            'status' => 'required|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['subdivision_name'], '-');

        $updated = $subdivision->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Subdivision ' . $subdivision->subdivision_name . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update subdivision ' . $subdivision->subdivision_name, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subdivision $subdivision)
    {
        $product = Product::where('subdivision_id', $subdivision->id)->first();
        if ($product) return response()->json([
            'message' =>
            'Product or many products belongs to this subdivision, so you cant delete!',
            'title' => 'Cant Delete',
            'status' => 'info'
        ], 200);

        if ($subdivision->delete()) {
            return response()->json(['message' => 'Division ' . $subdivision->subdivision_name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete Division ' . $subdivision->subdivision_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getSubdivisions($request)
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
        $totalRecords = Subdivision::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Subdivision::select('count(*) as allcount')
            ->join('categories', 'categories.id', 'subdivisions.category_id')
            ->join('subcategories', 'subcategories.id', 'subdivisions.subcategory_id')
            ->join('divisions', 'divisions.id', 'subdivisions.division_id')
            ->where('subdivision_name', 'like', '%' . $searchValue . '%')
            ->orWhere('division_name', 'like', '%' . $searchValue . '%')
            ->orWhere('category_name', 'like', '%' . $searchValue . '%')
            ->orWhere('subcategory_name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Subdivision::join('categories', 'categories.id', 'subdivisions.category_id')
            ->join('subcategories', 'subcategories.id', 'subdivisions.subcategory_id')
            ->join('divisions', 'divisions.id', 'subdivisions.division_id')
            ->where('subdivision_name', 'like', '%' . $searchValue . '%')
            ->orWhere('division_name', 'like', '%' . $searchValue . '%')
            ->orWhere('category_name', 'like', '%' . $searchValue . '%')
            ->orWhere('subcategory_name', 'like', '%' . $searchValue . '%')
            ->select('subdivisions.*', 'categories.category_name', 'subcategories.subcategory_name', 'divisions.division_name')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $category_id = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->category_name . '</span>
                        </span>
                    </div>';

            $subcategory_id = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->subcategory_name . '</span>
                        </span>
                    </div>';

            $division_id = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->division_name . '</span>
                        </span>
                    </div>';

            $subdivision_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->subdivision_name . '</span>
                        </span>
                    </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "category_id" => $category_id,
                "subcategory_id" => $subcategory_id,
                "division_id" => $division_id,
                "subdivision_name" => $subdivision_name,
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
