<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Division;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) $this->getSubcategories($request);
        $categories = Category::where('status', 1)->get();
        return view('console.sub-category.index', ['categories' => $categories]);
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
            'subcategory_name' => 'nullable|string|max:25|unique:subcategories',
            'subcategory_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'status' => 'nullable|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['subcategory_name'], '-');

        if ($request->subcategory_image) {
            $validated['subcategory_image'] = $request->file('subcategory_image')->storeAs('subcategories', $validated['slug'] . '.' . $request->file('subcategory_image')->getClientOriginalExtension());
        } else $validated['subcategory_image'] = 'subcategories/subcategory.png';

        $create = Subcategory::create($validated);

        if ($create) return response()->json(['message' => 'Subcategory ' . $request->subcategory_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Subcategory ' . $request->subcategory_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $sub_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $sub_category)
    {
        return response()->json(['message' => 'success', 'subcategory' => $sub_category], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $sub_category)
    {
        $validated = $request->validate([
            'category_id' => 'nullable',
            'subcategory_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'subcategory_name' => 'nullable|string|max:25|unique:subcategories,subcategory_name,' . $sub_category->id,
            'status' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['subcategory_name'], '-');

        if ($request->subcategory_image) {
            Storage::delete($sub_category->subcategory_image);
            $validated['subcategory_image'] = $request->file('subcategory_image')->storeAs('categories', $validated['slug'] . '.' . $request->file('subcategory_image')->getClientOriginalExtension());
        } else $validated['subcategory_image'] = $sub_category->subcategory_image;

        $updated = $sub_category->update($validated);

        if ($updated) {

            $products = Product::where('subcategory_id', $sub_category->id)->get();

            foreach ($products as $product) {
                $product->update([
                    'status' => $validated['status'],
                ]);
            }

            return response()->json(['message' => 'Subcategory ' . $sub_category->subcategory_name . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update subcategory ' . $sub_category->subcategory_name, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $sub_category)
    {
        

        $product = Product::where('subcategory_id', $sub_category->id)->first();
        if ($product) return response()->json([
            'message' =>
            'Product or many products belongs to this subcategory, so you cant delete!',
            'title' => 'Cant Delete',
            'status' => 'info'
        ], 200);

        if ($sub_category->delete()) {
            return response()->json(['message' => 'Subcategory ' . $sub_category->subcategory_name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete Subcategory ' . $sub_category->subcategory_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getSubcategories($request)
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
        $totalRecords = Subcategory::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Subcategory::select('count(*) as allcount')
            ->join('categories', 'categories.id', 'subcategories.category_id')
            ->where('subcategory_name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Subcategory::where('category_name', 'like', '%' . $searchValue . '%')
            ->join('categories', 'categories.id', 'subcategories.category_id')
            ->select('subcategories.*', 'categories.category_name')
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

            $sub_category_image = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/storage/$record->subcategory_image") . '" />
                        </span>
                    </div>';

            $sub_category_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->subcategory_name . '</span>
                        </span>
                    </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "category_id" => $category_id,
                "subcategory_name" => $sub_category_name,
                "subcategory_image" => $sub_category_image,
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

    public function getSubcategoriesByCategory(Category $category)
    {
        $subcategories = Subcategory::where('category_id', $category->id)->where('status', 1)->select('id', 'subcategory_name', 'status')->get();

        return response()->json(['status' => 'success', 'subcategories' => $subcategories, 'categoryStatus' => $category->status], 200);
    }
}
