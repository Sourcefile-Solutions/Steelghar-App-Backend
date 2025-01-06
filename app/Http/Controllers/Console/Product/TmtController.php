<?php

namespace App\Http\Controllers\Console\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tmtdetail;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class TmtController extends Controller
{
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $thicknesses = Tmtdetail::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        return view('console.product.add.tmt', ['categories' => $categories, 'thicknesses' => $thicknesses, 'brands' => $brands]);
    }


    protected function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|integer',
            'product_name' => 'required|string|max:50',
            'thickness_id' => 'required|integer',
            'status' => 'required|boolean',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'brand' => 'required|array|min:1',
            'seo_title' => 'nullable|string|max:250',
            'seo_keyword' => 'nullable|string|max:250',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $already = Product::where([['product_name', $validated['product_name']], ['category_id', $validated['category_id']]])->first();


        if ($already)  throw ValidationException::withMessages([
            'product_name' => 'product name already exist!'
        ]);



        $validated['slug'] = Str::slug($validated['product_name'], '-');

        if ($request->product_image) {
            $validated['product_image'] = $request->file('product_image')->storeAs('products', microtime() . '.' . $request->file('product_image')->getClientOriginalExtension());
        } else $validated['product_image'] = '';

        $validated['low_price'] = $this->findLowPrice($validated['brand'], $validated['thickness_id']);
        $validated['brand'] = json_encode($validated['brand']);

        $created = Product::create($validated);


        if ($created) return response()->json(['message' => 'Product ' . $created->product_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
        else return response()->json(['message', 'Failed to add Product ' . $created->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }

    public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'product_name' => 'required|string|max:50',
            'thickness_id' => 'required|integer',
            'status' => 'required|boolean',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'brand' => 'required|array|min:1',
            'seo_title' => 'nullable|string|max:250',
            'seo_keyword' => 'nullable|string|max:250',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $already = Product::whereNot('id', $product->id)->where([
            ['product_name', $validated['product_name']],
            ['category_id', $product->category_id],
        ])->first();


        if ($already)  throw ValidationException::withMessages([
            'product_name' => 'product name already exist!'
        ]);


        if ($already)  throw ValidationException::withMessages([
            'product_name' => 'product name already exist!'
        ]);

        $validated['low_price'] = $this->findLowPrice($validated['brand'], $validated['thickness_id']);

        $validated['brand'] = json_encode($validated['brand']);

        $validated['slug'] = Str::slug($validated['product_name'], '-');

        if ($request->product_image) {
            $validated['product_image'] = $request->file('product_image')->storeAs('products', microtime() . '.' . $request->file('product_image')->getClientOriginalExtension());
        } else $validated['product_image'] = $product->product_image;


        $updated = $product->update($validated);


        if ($updated) return response()->json(['message' => 'Product ' . $request->product_name . ' updated Successfully!', 'status' => 'success', 'title' => 'Updated!'], 201);
        else return response()->json(['message', 'Failed to update Product ' . $request->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }



    private function findLowPrice($brands, $thickness_id)
    {
        $brands = Brand::whereIn('id', $brands)->where('status', true)->select('id', 'brand_name', 'price')->get();;
        $tmtweight = Tmtdetail::find($thickness_id);
        return number_format($brands->min('price') * $tmtweight->weight, 2, '.', '');
    }
}
