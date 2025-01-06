<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPrice;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Tmtdetail;

class HomeController extends Controller
{
    public function index()
    {

        $banner = Banner::where('status', 1)->get();
        $popularCategories = Category::where('status', true)->take(6)->get();
        $latestProducts = Product::where('status', 1)->latest()->take(20)->get();
        $brands = Brand::get();
        return view('public.index', ['banner' => $banner, 'latestProducts' => $this->setupLatestProducts($latestProducts), 'brands' => $brands, 'popularCategories' => $popularCategories]);
    }



    protected function setupLatestProducts($products)
    {
        $p = [];
        foreach ($products as $product) {

            $a = [
                'product_name' => $product->product_name,
                'product_image' =>  $product->product_image ? asset('storage/' . $product->product_image) : asset('no-image.png'),
            ];
            if ($product->category_id == 1) {
                $brands = Brand::whereIn('id', json_decode($product->brand))->where('status', true)->select('id', 'brand_name', 'price')->get();;
                $tmtweight = Tmtdetail::find($product->thickness_id);
                array_push($p, [...$a, 'price_start' => number_format($brands->min('price') * $tmtweight->weight, 2)]);
            } else if ($product->category_id == 2) {
                $c = CategoryPrice::where('category_id', $product->category_id)->first();
                $attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'height',  'price')->get();
                $prices = [];
                foreach ($attributes as $attribute) {
                    array_push($prices, $attribute->height * ($c->price + $attribute->price));
                }
                array_push($p, [...$a, 'price_start' => number_format(min($prices), 2)]);
            } else if ($product->category_id == 3) {
                $c = CategoryPrice::where('category_id', $product->category_id)->first();
                $low_price = Productattribute::where('product_id', $product->id)->orderBy('price', 'asc')
                    ->value('price');
                array_push($p, [...$a, 'price_start' => number_format((($c->price + $low_price) * 1.3), 2)]);
            } else {
                $c = CategoryPrice::where('category_id', $product->category_id)->first();
                $product->attributes = Productattribute::where('product_id', $product->id)->select('id', 'thickness', 'weight', 'price')->get();
                $attributes = Productattribute::where('product_id', $product->id)->select('price', 'weight')->get();
                $prices = [];
                foreach ($attributes as $attribute) {
                    array_push($prices, $attribute->weight * ($c->price + $attribute->price));
                    // array_push($prices, $attribute->weight * ($attribute->price));
                }
                array_push($p, [...$a, 'price_start' => number_format(min($prices), 2)]);
            }
        }
        return $p;
    }
}
