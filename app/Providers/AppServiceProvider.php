<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Public\Cart;
use App\Models\Public\Cartproduct;
use App\Models\Setting;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::if('guestGuard', function ($guard = null) {
            return auth()->guard($guard)->guest();
        });

        Blade::if('authGuard', function ($guard = null) {
            return auth()->guard($guard)->check();
        });

        view()->composer('*', function ($view) {
            $settings = Setting::first();
            $categories = Category::where('status', true)->select('id', 'category_name', 'slug')->get();
            foreach ($categories as $category) {
                $category->subcategories = Subcategory::where([['category_id', $category->id], ['status', true]])->select('subcategory_name', 'slug')->get();
            }
            $searchData = Product::where('status', true)->select('product_name', 'product_image', 'slug')->get();
            view()->share([
                'settings' => $settings,
                'menues' => $categories,
                'cartCount' => $this->cartCount(),
                'searchData' => $searchData
            ]);
        });
    }

    private function cartCount()
    {
        if (Auth::guard('customer')->check()) {
            $cart = Cart::where([['customer_id', Auth::guard('customer')->user()->id], ['status', false]])->first();
            if (!$cart) return 0;
            return Cartproduct::where('cart_id', $cart->id)->count();
        }
    }
}
