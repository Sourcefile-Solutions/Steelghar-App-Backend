<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Public\Cart;
use App\Models\Public\Cartproduct;
use App\Models\Tmtdetail;
use Illuminate\Http\Request;

class BrandController extends Controller
{



    function index(Request $request)
    {
        if ($request->ajax()) $this->getBrands($request);
        return view('console.brand.index');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'brand_name' => 'required|string|max:25|unique:brands',
            'price' => 'nullable',
            'status' => 'nullable|boolean',
        ]);

        if ($request->logo) {
            $validated['logo'] = $request->file('logo')->storeAs('brands', $validated['brand_name'] . '.' . $request->file('logo')->getClientOriginalExtension());
        } else $validated['brand_name'] = 'brands/brand.png';

        $create = Brand::create($validated);

        if ($create) return response()->json(['message' => 'Brand ' . $request->brand_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Brand ' . $request->brand_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }


    public function edit(Brand $brand)
    {
        return response()->json(['message' => 'success', 'brand' => $brand], 200);
    }


    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'brand_name' => 'required|string|max:25|unique:brands,brand_name,' . $brand->id,
            'price' => 'nullable',
            'status' => 'nullable|boolean',
        ]);

        if ($request->logo) {
            Storage::delete($brand->logo);
            $validated['logo'] = $request->file('logo')->storeAs('brands', $validated['brand_name'] . '.' . $request->file('logo')->getClientOriginalExtension());
        } else $validated['logo'] = $brand->logo;

        $updated = $brand->update($validated);

        if ($updated) {

            $this->updateProducts("updated", $brand);
            return response()->json(['message' => 'Brand ' . $brand->brand_name . ' Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        }

        return response()->json(['message' => 'Failed to update Brand ' . $brand->brand_name, 'title' => 'Failed', 'status' => 'error'], 200);
    }


public function destroy(Brand $brand)
{
    // Check if the brand ID exists in any product's JSON-encoded 'brand' field
    $productsWithBrand = Product::whereRaw('JSON_CONTAINS(brand, ?)', [json_encode((string) $brand->id)])->exists();

    if ($productsWithBrand) {
        return response()->json([
            'message' => 'Product(s) belong to this brand, so you cannot delete it!',
            'title' => 'Cannot Delete',
            'status' => 'info'
        ], 200);
    }

    // Attempt to delete the brand
    if ($brand->delete()) {
        return response()->json([
            'message' => 'Brand ' . $brand->brand_name . ' deleted successfully!',
            'status' => 'success',
            'title' => 'Deleted'
        ], 201);
    }

    return response()->json([
        'message' => 'Failed to delete brand ' . $brand->brand_name,
        'status' => 'error',
        'title' => 'Failed!'
    ], 200);
}





    private function updateProducts($action, $brand)
    {
        if ($action == "update") {
            $products = Product::where('category_id', 1)->get();
            foreach ($products as $product) {
                $tmt_detail = Tmtdetail::find($product->thickness_id);
                $brands = Brand::whereIn('id', json_decode($product->brand))->where('status', true)->select('id', 'brand_name', 'price')->get();
                $product->low_price = number_format($brands->min('price') * $tmt_detail->weight, 2, '.', '');
                $product->save();
            }
        } else if ($action == "delete") {

            $products = Product::where('category_id', 1)->get();


            foreach ($products as $product) {
                $tmt_detail = Tmtdetail::find($product->thickness_id);
                $brands = json_decode($product->brand);
                if (in_array($brand->id, $brands)) {
                    $valueToRemove = $brand->id;
                    $brands = array_filter($brands, function ($value) use ($valueToRemove) {
                        return $value != $valueToRemove;
                    });
                    if (count(array_values($brands))) {
                        $brands = json_encode(array_values($products));
                        $product->json_encode($brands);
                        $brands = Brand::whereIn('id', $brands)->where('status', true)->select('id', 'brand_name', 'price')->get();
                        $product->low_price = number_format($brands->min('price') * $tmt_detail->weight, 2, '.', '');
                        $product->save();
                    } else {

                        $product->delete();

                        // remove from wishlist
                        // remove from cartproducts
                    }
                }
            }

            $carts = Cart::where('status', false)->pluck('id')->toArray();

            Cartproduct::whereIn('cart_id', $carts)->where('brand_id', $brand->id)->delete();
        }
    }

    public function getBrands($request)
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
        $totalRecords = Brand::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Brand::select('count(*) as allcount')
            ->where('brand_name', 'like', '%' . $searchValue . '%')
            ->orWhere('price', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Brand::where('brand_name', 'like', '%' . $searchValue . '%')
            ->orWhere('price', 'like', '%' . $searchValue . '%')
            ->select('brands.*')
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;

            $logo = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/storage/$record->logo") . '" />
                        </span>
                    </div>';

            $brand_name = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->brand_name . '</span>
                        </span>
                    </div>';

            $price = '<div class="d-flex align-items-center gap-3">
                        <span class="d-flex flex-column text-muted">
                            <span class="text-gray-800 text-hover-primary fw-bold">' . $record->price . '</span>
                        </span>
                    </div>';
            $record->status ? $status = "<span class='badge badge-success'>Active</span>" : $status = "<span class='badge badge-danger'>Block</span>";

            $data_arr[] = array(
                "id" => $id,
                "logo" => $logo,
                "brand_name" => $brand_name,
                "price" => $price,
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
