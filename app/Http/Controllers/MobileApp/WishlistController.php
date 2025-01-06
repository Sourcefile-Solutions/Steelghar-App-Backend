<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\Public\Wishlist;
use Illuminate\Http\Request;
use App\Models\Product;


class WishlistController extends Controller
{

    // public function index()
    // {


    //     $wishlistproducts = Product::whereIn('id', json_decode(auth()->user()->wishlists))
    //         ->select('product_name', 'product_image',  'category_id', 'id')
    //         ->get();
    //     return view('public.wishlist', ['wishlistproducts' => $wishlistproducts]);
    // }
    public function index()
    {
        $wishlist = Wishlist::where('customer_id', auth()->user()->id)->first();
        if ($wishlist) {
            $ws = $wishlist->products;
            if ($ws) $wishlist = json_decode($ws);
            else $wishlist = [];
        } else $wishlist = [];
        $wishlistproducts = Product::whereIn('id', $wishlist)->select('product_name', 'product_image',  'category_id', 'id')->get();
        return response()->json(['status' => 'success','count'=>$wishlistproducts->count(), 'wishlistProducts' => $wishlistproducts]);
    }


    public function addToWishlist(Request $request)
    {


        $wishlist = Wishlist::where('customer_id', auth()->user()->id)->first();

        if (!$wishlist) $wishlist = Wishlist::create([
            'customer_id' => auth()->user()->id,
            'products' => json_encode([])
        ]);


        if ($wishlist->products) {
            $products = json_decode($wishlist->products);

            if (in_array($request->product_id, $products)) {

                $valueToRemove = $request->product_id;
                $products = array_filter($products, function ($value) use ($valueToRemove) {
                    return $value != $valueToRemove;
                });

                if (count(array_values($products))) $wishlist->products = json_encode(array_values($products));
                else $wishlist->products = json_encode([]);
                if ($wishlist->save()) return response()->json(['status' => 'success','count'=>$wishlist->count(), 'action' => 'removed', 'message' => 'Product removed from wishlist']);
                return response()->json(['status' => 'error']);
            } else {

                $wishlist->products = json_encode([...$products, $request->product_id]);
                if ($wishlist->save())  return response()->json(['status' => 'success','count'=>$wishlist->count(), 'action' => 'added', 'message' => 'Product Added to wishlist']);

                return response()->json(['status' => 'error']);
            }
        } else {
            $wishlist->products = json_encode([$request->product_id]);

            if ($wishlist->save()) return response()->json(['status' => 'success','count'=>$wishlist->count(), 'action' => 'added', 'message' => 'Product Added to wishlist']);

            return response()->json(['status' => 'error']);
        }
    }
}
