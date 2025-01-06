<?php


namespace App\Http\Controllers\Console\Product;

use App\Http\Controllers\Controller;
use App\Models\CategoryPrice;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class MeshController extends Controller
{

    protected function store(Request $request)
    {

        $validated = $request->validate([
            'category_id' => 'required|integer',
            'product_name' => 'required|string|max:50',
            'status' => 'required|boolean',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
            'product_attributes' => 'required|array|min:1',
            'seo_title' => 'nullable|string|max:250',
            'seo_keyword' => 'nullable|string|max:250',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $already = Product::where([['product_name', $validated['product_name']], ['category_id', $validated['category_id']]])->first();


        if ($already)  throw ValidationException::withMessages([
            'product_name' => 'product name already exist!'
        ]);

        $meshPrice = CategoryPrice::where('category_id', 2)->pluck('price')->first();
        if (!count($validated['product_attributes'])) return 'error';
        $attributeError = [];
        $attributes = [];
        foreach ($validated['product_attributes'] as $key => $attribute) {
            if (($attribute['price'] + $meshPrice) < 0) {
                array_push($attributeError, [$key => 'Inavalid value']);
            } else {
                array_push($attributes, ['height' => $attribute['height'], 'price' => $attribute['price']]);
            }
        }
        if (count($attributeError)) return "error";
        unset($validated['product_attributes']);
        $validated['slug'] = Str::slug($validated['product_name'], '-');
        if ($request->product_image) {
            $validated['product_image'] = $request->file('product_image')->storeAs('products', microtime() . '.' . $request->file('product_image')->getClientOriginalExtension());
        } else $validated['product_image'] = '';

        $validated['low_price'] = $this->findLowPrice($attributes);


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

        $meshPrice = CategoryPrice::where('category_id', 2)->pluck('price')->first();
        if (!count($validated['product_attributes'])) return 'error';
        $attributeError = [];
        $attributes = [];



        foreach ($validated['product_attributes'] as $key => $attribute) {


            if (($attribute['price'] + $meshPrice) < 0) {
                array_push($attributeError, [$key => 'Inavalid value']);
            } else {
                if ($attribute['height']) array_push($attributes, ['height' => $attribute['height'], 'price' => $attribute['price']]);
            }
        }



        if (count($attributeError)) return "error";
        unset($validated['product_attributes']);
        $validated['slug'] = Str::slug($validated['product_name'], '-');
        if ($request->product_image) {
            $validated['product_image'] = $request->file('product_image')->storeAs('products', microtime() . '.' . $request->file('product_image')->getClientOriginalExtension());
        } else $validated['product_image'] = $product->product_image;

        $validated['low_price'] = $this->findLowPrice($attributes);

        $updated = $product->update($validated);

        if ($updated) {
            $a = [];
            foreach ($attributes as $attribute) {
                array_push($a, [...$attribute, 'product_id' => $product->id]);
            }

            ProductAttribute::where('product_id', $product->id)->delete();

            $inserted = ProductAttribute::insert($a);
            if ($inserted) return response()->json(['message' => 'Product ' . $request->product_name . ' Updated Successfully!', 'status' => 'success', 'title' => 'Updated!'], 201);
            // $product->delete();
            return response()->json(['message', 'Failed to add Product ' . $request->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
        }
        return response()->json(['message', 'Failed to updated Product ' . $request->product_name, 'status' => 'error', 'title' => 'Failed!'], 450);
    }


    private function findLowPrice($attributes)
    {

        $p = CategoryPrice::where('category_id', 2)->first();

        $lowestSubtotal = $this->getLowestSubtotalAmount($attributes, $p->price);

        return number_format($lowestSubtotal, 2, '.', '');
    }



    function getLowestSubtotalAmount(array $items, $price): float
    {
        $lowestSubtotal = null;

        foreach ($items as $item) {
            $subtotal = $item['height'] * ($price + $item['price']);
            if ($lowestSubtotal === null || $subtotal < $lowestSubtotal) {
                $lowestSubtotal = $subtotal;
            }
        }

        return $lowestSubtotal;
    }
}
