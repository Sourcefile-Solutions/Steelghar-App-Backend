<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Cartproduct;
use App\Models\User;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::join('users', 'users.id', 'carts.user_id')->where('carts.status', false)->select('name', 'phone', 'carts.id')->get();

        foreach ($carts as $cart) {

            $cart->count = Cartproduct::where('cart_id', $cart->id)->count();
        }


        return view('cart.index', ['carts' => $carts]);
    }

    public function show($id)
    {
        $cart = Cart::find($id);

        if (!$cart) return redirect()->back();

        $cartProducts = Cartproduct::join('products', 'products.id', 'cart_products.product_id')->where('cart_id', $id)
            ->select('product_name', 'category_id', 'brand_id', 'weight', 'thickness', 'length')
            ->get();

        foreach ($cartProducts as $x) {

            if ($x->category_id == '2') {
                $brand = Brand::find($x->brand_id);
                $x->brand = $brand->brand_name;
            }
        }


        $customer = User::find($cart->user_id);

        return view('cart.show', ['cart' => $cart, 'customer' => $customer, 'cartProducts' => $cartProducts]);
    }
}
