<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Division;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use App\Models\Subdivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DivisionController extends Controller
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
        if ($request->ajax()) $this->getDivisions($request);
        $categories = Category::where('status', 1)->get();
        $subcategories = Subcategory::where('status', 1)->get();
        return view('division.index', ['categories' => $categories, 'subcategories' => $subcategories]);
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
            'category_id' => 'nullable',
            'subcategory_id' => 'nullable',
            'division_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'division_name' => 'required|string',
            'status' => 'nullable|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['division_name'], '-');
        if ($request->division_image) {
            $validated['division_image'] = $request->file('division_image')->storeAs('divisions', $validated['slug'] . '.' . $request->file('division_image')->getClientOriginalExtension());
        } else $validated['division_image'] = 'divisions/division.png';

        $create = Division::create($validated);

        if ($create) return response()->json(['message' => 'Division ' . $request->division_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Division ' . $request->division_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        return response()->json(['message' => 'success', 'division' => $division], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'division_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'division_name' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['division_name'], '-');

        if ($request->division_image) {
            Storage::delete($division->division_image);
            $validated['division_image'] = $request->file('division_image')->storeAs('divisions', $validated['slug'] . '.' . $request->file('division_image')->getClientOriginalExtension());
        } else $validated['division_image'] = $division->division_image;

        $updated = $division->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Division ' . $division->division_name . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update division ' . $division->division_name, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $subdivision = Subdivision::where('division_id', $division->id)->first();
        if ($subdivision) return response()->json([
            'message' =>
            'Subdivision or many subdivisions belongs to this division, so you cant delete!',
            'title' => 'Cant Delete',
            'status' => 'info'
        ], 200);

        $product = Product::where('division_id', $division->id)->first();
        if ($product) return response()->json([
            'message' =>
            'Product or many products belongs to this division, so you cant delete!',
            'title' => 'Cant Delete',
            'status' => 'info'
        ], 200);

        if ($division->delete()) {
            return response()->json(['message' => 'Division ' . $division->division_name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete Division ' . $division->division_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getDivisions($request)
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
        $totalRecords = Division::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Division::select('count(*) as allcount')
            ->join('categories', 'categories.id', 'divisions.category_id')
            ->join('subcategories', 'subcategories.id', 'divisions.subcategory_id')
            ->where('division_name', 'like', '%' . $searchValue . '%')
            ->orWhere('category_name', 'like', '%' . $searchValue . '%')
            ->orWhere('subcategory_name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Division::join('categories', 'categories.id', 'divisions.category_id')
            ->join('subcategories', 'subcategories.id', 'divisions.subcategory_id')
            ->where('division_name', 'like', '%' . $searchValue . '%')
            ->orWhere('category_name', 'like', '%' . $searchValue . '%')
            ->orWhere('subcategory_name', 'like', '%' . $searchValue . '%')
            ->select('divisions.*', 'categories.category_name', 'subcategories.subcategory_name')
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

            $division_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->division_name . '</span>
                        </span>
                    </div>';

            $division_image = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/public/storage/$record->division_image") . '" />
                        </span>
                    </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "category_id" => $category_id,
                "subcategory_id" => $subcategory_id,
                "division_name" => $division_name,
                "division_image" => $division_image,
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

    public function getDivisionsBySubcategory(Subcategory $subcategory)
    {
        $divisions = Division::where('subcategory_id', $subcategory->id)->where('status', 1)->select('id', 'division_name', 'status')->get();

        return response()->json(['status' => 'success', 'divisions' => $divisions, 'subcategoryStatus' => $subcategory->status], 200);
    }
}
