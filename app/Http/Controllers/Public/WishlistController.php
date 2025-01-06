<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\CategoryPrice;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Public\Wishlist as PublicWishlist;
use App\Models\RoofingColor;
use App\Models\Subcategory;
use App\Models\Tmtdetail;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{

    public function index()
    {


        $wishlistproducts = Product::whereIn('id', json_decode(auth()->user()->wishlists))
            ->select('product_name', 'product_image',  'category_id', 'id')
            ->get();
        return view('public.wishlist', ['wishlistproducts' => $wishlistproducts]);
    }



    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);
        $user = auth()->user();

        $products = json_decode($user->wishlists);

        if (in_array($request->product_id, $products)) {

            $valueToRemove = $request->product_id;
            $products = array_filter($products, function ($value) use ($valueToRemove) {
                return $value != $valueToRemove;
            });

            if (count(array_values($products))) $user->wishlists = json_encode(array_values($products));
            else $user->wishlists = json_encode([]);
            if ($user->save()) return response()->json(['status' => 'success', 'action' => 'removed', 'message' => 'Product removed from wishlist']);
            return response()->json(['status' => 'error']);
        } else {

            $user->wishlists = json_encode([...$products, $request->product_id]);
            if ($user->save())  return response()->json(['status' => 'success', 'action' => 'added', 'message' => 'Product Added to wishlist']);

            return response()->json(['status' => 'error']);
        }
    }




    public function addToCart($id)
    {
        $product = Product::select(
            'id',
            'category_id',
            'subcategory_id',
            'product_name',
            'slug',
            'product_image',
            'brand',
            'seo_title',
            'seo_keyword',
            'seo_description',
            'thickness_id',
            'low_price'
        )->find($id);

        return view('public.wishlist-add-to-cart', ['product' => $this->setupProducts($product)])->render();
    }

    protected function setupProducts($product)
    {




        if ($product->category_id == 1) {;
            $brands = Brand::whereIn('id', json_decode($product->brand))->where('status', true)->select('id', 'brand_name', 'price')->get();;
            $tmtweight = Tmtdetail::find($product->thickness_id);
            $product->weight = $tmtweight->weight;
            $product->price_start = number_format($brands->min('price') * $tmtweight->weight, 2, '.', '');
            $product->brands = $brands;
        } else if ($product->category_id == 2) {


            $p = CategoryPrice::where('category_id', $product->category_id)->first();
            $product->category_price = $p->price;
            $product->attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'height',  'price')->get();
            $low_price = ProductAttribute::where('product_id', $product->id)->orderBy(DB::raw('price * weight'), 'asc')
                ->first();
            $product->low_price = $low_price->height * ($p->price + $low_price->price);
        } else if ($product->category_id == 3) {

            $p = CategoryPrice::where('category_id', $product->category_id)->first();
            $product->category_price = $p->price;
            $product->attributes = ProductAttribute::join('roofing_thicknesses', 'roofing_thicknesses.id', 'product_attributes.thickness')
                ->where('product_id', $product->id)->select('product_attributes.id', 'roofing_thicknesses.thickness',  'price', 'formula_value')->get();

            $product->colors = RoofingColor::where('status', true)->get();
            $low_price = ProductAttribute::where('product_id', $product->id)->orderBy('price', 'asc')
                ->value('price');
            $product->low_price = ($p->price + $low_price) * 1.3;
        } else {

            if ($product->subcategory_id) {
                $subcategory = Subcategory::find($product->subcategory_id);
                $product->subcategory = $subcategory->subcategory_name;
            }
            $p = CategoryPrice::where('category_id', $product->category_id)->first();
            $product->category_price = $p->price;

            $product->attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'thickness', 'weight', 'price')->get();
            $low_price = ProductAttribute::where('product_id', $product->id)->orderBy(DB::raw('price * weight'), 'asc')
                ->first();
            $product->low_price = $low_price->weight * ($p->price + $low_price->price);
        }


        return $product;
    }
}
