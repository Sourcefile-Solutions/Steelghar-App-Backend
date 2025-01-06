<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Division;
use App\Models\Materialsize;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class MaterialsizeController extends Controller
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
        if ($request->ajax()) $this->getMaterialsize($request);
        $categories = Category::where('status', 1)->get();
        $subcategories = Subcategory::where('status', 1)->get();
        $divisions = Division::where('status', 1)->get();
        return view('material-size.index', ['categories' => $categories, 'subcategories' => $subcategories, 'divisions' => $divisions]);
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
            'dimention' => 'required',
            'thickness' => 'required',
            'weight' => 'required',
            'status' => 'required|boolean',
        ]);

        $create = Materialsize::create($validated);

        if ($create) return response()->json(['message' => 'Material Size ' . $request->dimention . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add material size ' . $request->dimention, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Materialsize $materialsize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materialsize $materialsize)
    {
        return response()->json(['message' => 'success', 'materialsize' => $materialsize], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materialsize $materialsize)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'nullable',
            'division_id' => 'nullable',
            'dimention' => 'required',
            'thickness' => 'required',
            'weight' => 'required',
            'status' => 'required|boolean',
        ]);

        $updated = $materialsize->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Material Size ' . $materialsize->dimention . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update material size ' . $materialsize->dimention, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materialsize $materialsize)
    {
        if ($materialsize->delete()) {
            return response()->json(['message' => 'Material Size ' . $materialsize->dimention . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete material size ' . $materialsize->dimention, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getMaterialsize($request)
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
        $totalRecords = Materialsize::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Materialsize::select('count(*) as allcount')
            ->join('categories', 'categories.id', 'materialsizes.category_id')
            ->join('subcategories', 'subcategories.id', 'materialsizes.subcategory_id')
            ->leftjoin('divisions', 'divisions.id', 'materialsizes.division_id')
            ->where('dimention', 'like', '%' . $searchValue . '%')
            ->orWhere('division_name', 'like', '%' . $searchValue . '%')
            ->orWhere('category_name', 'like', '%' . $searchValue . '%')
            ->orWhere('subcategory_name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Materialsize::join('categories', 'categories.id', 'materialsizes.category_id')
            ->join('subcategories', 'subcategories.id', 'materialsizes.subcategory_id')
            ->leftjoin('divisions', 'divisions.id', 'materialsizes.division_id')
            ->where('dimention', 'like', '%' . $searchValue . '%')
            ->orWhere('division_name', 'like', '%' . $searchValue . '%')
            ->orWhere('category_name', 'like', '%' . $searchValue . '%')
            ->orWhere('subcategory_name', 'like', '%' . $searchValue . '%')
            ->select('materialsizes.*', 'categories.category_name', 'subcategories.subcategory_name', 'divisions.division_name')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $product_fields = '<div class="d-flex align-items-center gap-3">
                <span class="d-flex flex-column text-muted">
                   <span class="text-gray-800 text-hover-primary fw-bold"><span>Category : </span>' . $record->category_name . '</span>
                    <span class="text-gray-800 text-hover-primary fw-bold"><span>Subcategory : </span>' . $record->subcategory_name . '</span>
                    <span class="text-gray-800 text-hover-primary fw-bold"><span>Division : </span>' . $record->division_name . '</span>
                </span>
            </div>';

            $dimention = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->dimention . '</span>
                        </span>
                    </div>';

            $thickness = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->thickness . '</span>
                        </span>
                    </div>';

            $weight = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->weight . '</span>
                        </span>
                    </div>';


            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "product_fields" => $product_fields,
                "dimention" => $dimention,
                "thickness" => $thickness,
                "weight" => $weight,
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
