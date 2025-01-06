<?php

namespace App\Http\Controllers\Console\Product;

use App\Http\Controllers\Controller;
use App\Models\CategoryPrice;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OtherProductController extends Controller
{

    protected function store(Request $request)
    {

        $validated = $request->validate([
            'category_id' => 'required|integer',
            'subcategory_id' => 'nullable|integer',
            'product_name' => 'required|string|max:50',
            'status' => 'required|boolean',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'product_attributes' => 'required|array|min:1',
            'seo_title' => 'nullable|string|max:250',
            'seo_keyword' => 'nullable|string|max:250',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $already = Product::where('product_name', $validated['product_name'])
            ->where('category_id', $validated['category_id'])
            ->when($validated['subcategory_id'] !== null, function ($query) use ($validated) {
                return $query->where('subcategory_id', $validated['subcategory_id']);
            })
            ->first();

        if ($already)  throw ValidationException::withMessages([
            'product_name' => 'product name already exist!'
        ]);

        $categoryPrice = CategoryPrice::where('category_id', $validated['category_id'])->pluck('price')->first();

        if (!count($validated['product_attributes'])) return 'error';
        $attributeError = [];
        $attributes = [];
        foreach ($validated['product_attributes'] as $key => $attribute) {
            if (($attribute['price'] + $categoryPrice) < 0) {
                array_push($attributeError, [$key => 'Inavalid value']);
            } else {
                array_push($attributes, ['thickness' => $attribute['thickness'], 'weight' => $attribute['weight'], 'price' => $attribute['price']]);
            }
        }
        if (count($attributeError)) return "error";
        unset($validated['product_attributes']);
        $validated['slug'] = Str::slug($validated['product_name'], '-');
        if ($request->product_image) {
            $validated['product_image'] = $request->file('product_image')->storeAs('products', microtime() . '.' . $request->file('product_image')->getClientOriginalExtension());
        } else $validated['product_image'] = '';

        $validated['low_price']  =  $this->findLowPrice($attributes, $validated['category_id']);
        $product = Product::create($validated);
        if ($product) {
            $a = [];
            foreach ($attributes as $attribute) {
                array_push($a, [...$attribute, 'product_id' => $product->id]);
            }
            $inserted = ProductAttribute::insert($a);
            if ($inserted) return response()->json(['message' => 'Product ' . $request->product_name . ' Added Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
            $product->delete();
            return response()->json(['message', 'Failed to add Product ' . $request->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
        }
        return response()->json(['message', 'Failed to add Product ' . $request->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }


    public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'product_name' => 'required|string|max:50',
            'status' => 'required|boolean',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'product_attributes' => 'required|array|min:1',
            'seo_title' => 'nullable|string|max:250',
            'seo_keyword' => 'nullable|string|max:250',
            'seo_description' => 'nullable|string|max:500',
        ]);


        $already = Product::where('product_name', $validated['product_name'])
            ->where('category_id', $product->category_id)
            ->when($product->category_id !== null, function ($query) use ($product) {
                return $query->where('subcategory_id', $product->category_id);
            })->whereNot('id', $product->id)
            ->first();


        if ($already)  throw ValidationException::withMessages([
            'product_name' => 'product name already exist!'
        ]);


        $categoryPrice = CategoryPrice::where('category_id', $product->category_id)->pluck('price')->first();


        if (!count($validated['product_attributes'])) return 'error';
        $attributeError = [];
        $attributes = [];
        foreach ($validated['product_attributes'] as $key => $attribute) {
            if (($attribute['price'] + $categoryPrice) < 0) {
                array_push($attributeError, [$key => 'Inavalid value']);
            } else {
                array_push($attributes, ['thickness' => $attribute['thickness'], 'weight' => $attribute['weight'], 'price' => $attribute['price']]);
            }
        }

        if (count($attributeError)) return "error";

        unset($validated['product_attributes']);

        $validated['slug'] = Str::slug($validated['product_name'], '-');

        if ($request->product_image) {
            $validated['product_image'] = $request->file('product_image')->storeAs('products', microtime() . '.' . $request->file('product_image')->getClientOriginalExtension());
        } else $validated['product_image'] = $product->product_image;


        $validated['low_price']  =  $this->findLowPrice($attributes, $product->category_id);

        $update = $product->update($validated);

        if ($update) {
            $a = [];
            foreach ($attributes as $attribute) {
                array_push($a, [...$attribute, 'product_id' => $product->id]);
            }

            ProductAttribute::where('product_id', $product->id)->delete();
            $inserted = ProductAttribute::insert($a);


            if ($inserted) return response()->json(['message' => 'Product ' . $request->product_name . ' Updated Successfully!', 'status' => 'success', 'title' => 'Added!'], 201);
            $product->delete();
            return response()->json(['message', 'Failed to update Product ' . $request->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
        }
        return response()->json(['message', 'Failed to update Product ' . $request->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }


    private function findLowPrice($attributes, $category_id)
    {
        $p = CategoryPrice::where('category_id', $category_id)->first();
        $lowestSubtotal = $this->getLowestSubtotalAmount($attributes, $p->price);
        return number_format($lowestSubtotal, 2, '.', '');
    }



    private function getLowestSubtotalAmount($items, $price)
    {
        $lowestSubtotal = null;
        foreach ($items as $item) {
            $subtotal = ($price + $item['price']) * $item['weight'];
            if ($lowestSubtotal === null || $subtotal < $lowestSubtotal) {
                $lowestSubtotal = $subtotal;
            }
        }
        return $lowestSubtotal;
    }
}
