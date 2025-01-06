<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPrice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Public\Cart;
use App\Models\Public\Cartproduct;
use App\Models\RoofingThickness;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use App\Models\Tmtdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) $this->getProducts($request);
        return view('console.product.index');
    }




    public function addtmt()
    {
        $categories = Category::where('status', 1)->get();
        $thicknesses = Tmtdetail::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        return view('console.product.add.tmt', ['categories' => $categories, 'thicknesses' => $thicknesses, 'brands' => $brands]);
    }

    public function addmesh()
    {
        $meshPrice = CategoryPrice::where('category_id', 2)->pluck('price')->first();
        return view('console.product.add.mesh', ['meshPrice' => $meshPrice]);
    }

    public function addroof()
    {
        $roofThickness = RoofingThickness::get();
        $roofPrice = CategoryPrice::where('category_id', 3)->pluck('price')->first();
        return view('console.product.add.roof', ['roofPrice' => $roofPrice, 'roofThickness' => $roofThickness]);
    }

    public function addother()
    {
        $subcategories = Subcategory::all();

        $categories = Category::where('status', 1)->whereNotIn('id', [1, 2, 3])->select('id', 'category_name')->get();

        $categoryPrice = CategoryPrice::select('id', 'price', 'category_id')->get();
        return view('console.product.add.other', ['subcategories' => $subcategories, 'categories' => $categories, 'categoryPrice' => $categoryPrice]);
    }












    public function getProductForm(Request $request)
    {


        $data = match ($request->category_id) {
            '1' => view(
                'console.product.tmt.create-form',
                [
                    'category_id' => $request->category_id,
                    'brands' => Brand::where('status', true)->get(),
                    'thicknesses' => Tmtdetail::where('status', true)->get()
                ]
            )->render(),
            '2' => 200,
            default => throw new \Exception('Unsupported'),
        };

        return response()->json(['form' => $data]);
    }

    public function create()
    {
        $categories = Category::where('status', 1)->whereNotIn('id', [1, 2, 3])->get();


        $subcategories = Subcategory::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $thicknesses = Tmtdetail::where('status', 1)->get();

        $roofPrice = CategoryPrice::where('category_id', 3)->pluck('price')->first();
        return view('console.product.create', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
            'thicknesses' => $thicknesses,
            // 'meshPrice' => $meshPrice,
            'roofPrice' => $roofPrice,
            'categoryPrice' => CategoryPrice::where('category_id', 8)->pluck('price')->first(),
            'category_id' => 8
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        return match ($request->category_id) {

            default => $this->otherStore($request),
        };

        // return $request->product_attributes;
        $validated = $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'nullable',
            'dimension' => 'nullable',
            'thickness_id' => 'nullable',
            'tmtweight' => 'nullable',
            'product_name' => 'required|string|max:25|unique:products',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'brand' => 'nullable',
            'status' => 'nullable|boolean',
            'seo_title' => 'nullable|string',
            'seo_keyword' => 'nullable|string',
            'seo_description' => 'nullable|string'
        ]);

        // return $validated;
        $validated['slug'] = Str::slug($validated['product_name'], '-');

        if ($request->brand) {
            $brands_price = Brand::whereIn('id', $validated['brand'])->pluck('price')->toArray();
            $validated['low_price'] = min($brands_price);
            $brands = $validated['brand'];
            $validated['brand'] = implode(',', $brands);
        }

        if ($request->product_image) {
            $validated['product_image'] = $request->file('product_image')->storeAs('products', microtime() . '.' . $request->file('product_image')->getClientOriginalExtension());
        } else $validated['product_image'] = 'products/product.png';


        $create = Product::create($validated);
        // return $create;
        if ($create) {

            foreach ($request->product_attributes as $abc) {

                ProductAttribute::create([
                    'product_id' => $create->id,
                    'thickness' => $abc['thickness'],
                    'roof_thickness' => $abc['roof_thickness'],
                    'height' => $abc['height'],
                    'weight' => $abc['weight'],
                    'price' => $abc['price'],
                    'price_kg' => $abc['price_kg'],
                ]);
            }
        }

        if ($create) return response()->json(['message' => 'Product ' . $request->product_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Product ' . $request->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }







    public function edit(Product $product)
    {
        // $categories = Category::where('status', 1)->get();
        // $subcategories = Subcategory::where('status', 1)->get();
        // $brands = Brand::where('status', 1)->get();
        // $attributes = ProductAttribute::where('product_id', $product->id)->get();
        // $tmtdetails = Tmtdetail::where('status', 1)->get();
        // return view('console.product.edit', ['product' => $product, 'categories' => $categories, 'subcategories' => $subcategories, 'brands' => $brands, 'attributes' => $attributes, 'tmtdetails' => $tmtdetails]);


        if ($product->category_id == 1) {
            $categories = Category::where('status', 1)->get();
            $thicknesses = Tmtdetail::where('status', 1)->get();
            $brands = Brand::where('status', 1)->get();
            $weight = Tmtdetail::find($product->thickness_id);



            return view('console.product.edit.tmt', ['selectedBrands' => json_decode($product->brand), 'weight' => $weight->weight, 'categories' => $categories, 'thicknesses' => $thicknesses, 'brands' => $brands, 'product' => $product,]);
        } else if ($product->category_id == 2) {

            $attributes = ProductAttribute::where('product_id', $product->id)->get();


            $meshPrice = CategoryPrice::where('category_id', 2)->pluck('price')->first();
            return view('console.product.edit.mesh', ['meshPrice' => $meshPrice, 'product' => $product, 'attributes' => $attributes]);
        } else if ($product->category_id == 3) {
            $roofThickness = RoofingThickness::get();
            $attributes = ProductAttribute::where('product_id', $product->id)->get();
            $roofPrice = CategoryPrice::where('category_id', 3)->pluck('price')->first();
            return view('console.product.edit.roof', [
                'roofPrice' => $roofPrice,
                'product' => $product,
                'attributes' => $attributes,
                'roofThickness' => $roofThickness
            ]);
        } else {

            $categoryPrice = CategoryPrice::where('category_id', $product->category_id)->first();
            $attributes = ProductAttribute::where('product_id', $product->id)->get();
            return view('console.product.edit.other', ['categoryPrice' => $categoryPrice->price, 'product' => $product, 'attributes' => $attributes]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'category_id' => 'nullable',
            'subcategory_id' => 'nullable',
            'thickness_id' => 'nullable',
            'tmtweight' => 'nullable',
            'product_name' => 'required|string|max:25|unique:products,product_name,' . $product->id,
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'brand' => 'nullable',
            'status' => 'nullable|boolean',
            'seo_title' => 'nullable|string',
            'seo_keyword' => 'nullable|string',
            'seo_description' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['product_name'], '-');

        if ($request->brand) {
            $brands_price = Brand::whereIn('id', $validated['brand'])->pluck('price')->toArray();

            $validated['low_price'] = min($brands_price);

            $brands = $validated['brand'];
            $validated['brand'] = implode(',', $brands);
        }

        if ($request->product_image) {
            Storage::delete($product->product_image);
            $validated['product_image'] = $request->file('product_image')->storeAs('products', microtime() . '.' . $request->file('product_image')->getClientOriginalExtension());
        } else $validated['product_image'] = $product->product_image;


        $update = $product->update($validated);

        if ($update) {

            $ffff = [];
            if ($request->product_attributes)

                foreach ($request->product_attributes as $abc) {
                    if ($abc['att_id'])  array_push($ffff, $abc['att_id']);
                }
            ProductAttribute::whereNotIn('id', $ffff)->where('product_id', $product->id)->delete();



            foreach ($request->product_attributes as $abc) {



                $attribute = ProductAttribute::find($abc['att_id']);



                if ($abc['att_id']) {
                    $attribute->update([
                        'thickness' => $abc['thickness'],
                        'weight' => $abc['weight'],
                        'price' => $abc['price'],
                        'price_kg' => $abc['price_kg'],
                    ]);
                } else {

                    if ($abc['thickness']) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'thickness' => $abc['thickness'],
                            'roof_thickness' => $abc['roof_thickness'],
                            'weight' => $abc['weight'],
                            'price' => $abc['price'],
                            'price_kg' => $abc['price_kg'],
                        ]);
                    }
                }
            }
        }

        if ($update) {
            return response()->json(['message' => 'Product ' . $product->product_name . ' Updated successfully!', 'status' => 'success', 'title' => 'Updated'], 201);
        }

        return response()->json(['message' => 'Failed to update product ' . $product->product_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */


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
        $totalRecords = Product::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Product::select('count(*) as allcount')
            ->join('categories', 'categories.id', 'products.category_id')
            ->leftjoin('subcategories', 'subcategories.id', 'products.subcategory_id')
            ->where('category_name', 'like', '%' . $searchValue . '%')
            ->orWhere('product_name', 'like', '%' . $searchValue . '%')
            ->count();
        // Fetch records
        $records = Product::join('categories', 'categories.id', 'products.category_id')
            ->leftjoin('subcategories', 'subcategories.id', 'products.subcategory_id')
            ->where('category_name', 'like', '%' . $searchValue . '%')
            ->orWhere('product_name', 'like', '%' . $searchValue . '%')
            ->select('products.*', 'categories.category_name', 'subcategories.subcategory_name')
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
            $product_fields .= ' </span>
            </div>';
            $product_image = '<div class="d-flex align-items-center gap-3">
                        <span class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                            <img src="' . asset("/storage/$record->product_image") . '" />
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


    public function destroy(Product $product)
    {
        if ($product->delete()) {

            $this->updateWishlistAndCartProducts($product->id);
            return response()->json(['message' => 'Product ' . $product->product_name . ' Deleted successfully!', 'status' => 'success', 'title' => 'Deleted'], 201);
        }
        return response()->json(['message' => 'Failed to delete product ' . $product->product_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }


    private function updateWishlistAndCartProducts($product_id)
    {
        $customers = Customer::get();
        foreach ($customers as $customer) {
            $wishlist = json_decode($customer->wishlists);
            if (in_array($product_id, $wishlist)) {
                $wishlist = array_filter($wishlist, function ($value) use ($product_id) {
                    return $value != $product_id;
                });
                if (count(array_values($wishlist))) $customer->wishlists = json_encode(array_values($wishlist));
                else $customer->wishlists = json_encode([]);
                if ($customer->save()) return response()->json(['status' => 'success', 'action' => 'removed', 'message' => 'Product removed from wishlist']);
                return response()->json(['status' => 'error']);
            }
        }

        $carts = Cart::where('status', false)->pluck('id')->toArray();

        Cartproduct::whereIn('cart_id', $carts)->where('product_id', $product_id)->delete();
    }
}
