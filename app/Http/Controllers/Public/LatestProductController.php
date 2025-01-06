<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Pricesetting;
use App\Models\Product;
use App\Models\Productattribute;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LatestProductController extends Controller
{
    public function latestProduct($category = null, $subcategory = null)
    {


        $products = Product::latest()->take(20)->get();
        foreach ($products as $product) {
            if ($product->category_id == 1) {
                //    return  $product->brand;
                $new_brands = explode(',', $product->brand);
                // return $new_brands;
                $product->brands = Brand::whereIn('id', $new_brands)->get();
            } else {
                $product->thick = Productattribute::where('product_id', $product->id)->get();
                // return $product->thick;
            }
            $basePrice = Pricesetting::where('cat_id', $product->category_id)->value('price');
            $product->basePrice = $basePrice;

            if (Auth::check()) {
                $wishlistproduct = Wishlist::where('user_id', auth()->user()->id)->first();

                if ($wishlistproduct) {
                    $wishlistproduct = explode(",", $wishlistproduct->product_id);
                    in_array($product->id, $wishlistproduct) ?  $product->isWishlist = true :  $product->isWishlist = false;
                } else {
                    $product->isWishlist = false;
                }
            } else {
                $product->isWishlist = false;
            }
        }

        if (Auth::check()) {
            $wishlistproduct = Wishlist::where('user_id', auth()->user()->id)->pluck('product_id')->toArray();

            in_array($product->id, $wishlistproduct) ?  $product->isWishlist = true :  $product->isWishlist = false;
        } else {
            $product->isWishlist = false;
            // return $product;
        }


        // $products = Product::latest()->take(20)->get();
        return view('latestproduct', ['products' => $products]);
    }
}
