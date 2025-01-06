<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryPrice;
use App\Models\Pricesetting;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) $this->getCategories($request);
        return view('console.category.index');
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
            'category_name' => 'nullable|string|unique:categories',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'status' => 'nullable|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['category_name'], '-');
        if ($request->category_image) {
            $validated['category_image'] = $request->file('category_image')->storeAs('categories', $validated['slug'] . '.' . $request->file('category_image')->getClientOriginalExtension());
        } else $validated['category_image'] = 'categories/category.png';

        $create = Category::create($validated);

        if ($create) {
            CategoryPrice::create(['category_id' => $create->id, 'price' => 0]);
            return response()->json(['message' => 'Category ' . $request->category_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        } else return response()->json(['message', 'Failed to add category ' . $request->category_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return response()->json(['message' => 'success', 'category' => $category], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'category_name' => 'nullable|string|unique:categories,category_name,' . $category->id,
            'status' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['category_name'], '-');

        if ($request->category_image) {
            Storage::delete($category->category_image);
            $validated['category_image'] = $request->file('category_image')->storeAs('categories', $validated['slug'] . '.' . $request->file('category_image')->getClientOriginalExtension());
        } else $validated['category_image'] = $category->category_image;

        $updated = $category->update($validated);

        if ($updated) {
            return response()->json(['message' => 'Category ' . $category->category_name . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update category ' . $category->category_name, 'title' => 'Failed', 'status' => 'error'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $subcategory = Subcategory::where('category_id', $category->id)->first();
        if ($subcategory) return response()->json([
            'message' =>
            'Subcategory or many subcategories belongs to this category, so you cant delete!',
            'title' => 'Cant Delete',
            'status' => 'info'
        ], 200);

        $product = Product::where('category_id', $category->id)->first();
        if ($product) return response()->json([
            'message' =>
            'Product or many products belongs to this category, so you cant delete!',
            'title' => 'Cant Delete',
            'status' => 'info'
        ], 200);

        if ($category->delete()) {
            return response()->json(['message' => 'Category ' . $category->category_name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete category ' . $category->category_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function getCategories($request)
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
        $totalRecords = Category::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Category::select('count(*) as allcount')
            ->where('category_name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Category::where('category_name', 'like', '%' . $searchValue . '%')
            ->select('categories.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $category_image = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/storage/$record->category_image") . '" />
                        </span>
                    </div>';

            $category_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->category_name . '</span>
                        </span>
                    </div>';

            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "category_image" => $category_image,
                "category_name" => $category_name,
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
