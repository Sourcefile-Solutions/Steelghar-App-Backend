<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPrice;
use App\Models\Pricesetting;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Public\Wishlist;
use App\Models\Roofing;
use App\Models\RoofingColor;
use App\Models\Subcategory;
use App\Models\Tmtdetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index($category = null, $subcategory = null)
    {

        if ($category && $subcategory) return $this->subcategoryProducts($category, $subcategory);

        else if ($category && !$subcategory) return $this->categoryProducts($category);

        $products = Product::where('status', true)->select(
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
        )->latest()->get();
        // return $this->setupProducts($products);
        return view('public.products.index', ['products' => $this->setupProducts($products)]);
    }


    protected function categoryProducts($category)
    {
        $category = Category::where('slug', $category)->first();

        $products = Product::where([['status', true], ['category_id', $category->id]])->select(
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
        )->latest()->get();

        return view('public.products.index', ['products' => $this->setupProducts($products)]);
    }

    protected function subcategoryProducts($category, $subcategory)
    {
        $category    = Category::where('slug', $category)->first();
        $subcategory = Subcategory::where('slug', $subcategory)->first();
        $products = Product::where([['status', true], ['category_id', $category->id], ['subcategory_id', $subcategory->id]])->select(
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
        )->latest()->get();


        return view('public.products.index', ['products' => $this->setupProducts($products)]);
    }

    protected function setupProducts($products)
    {

        $wislist = json_decode(auth()->user()->wishlists);

        foreach ($products as $product) {

            if ($product->category_id == 1) {;
                $brands = Brand::whereIn('id', json_decode($product->brand))->where('status', true)->select('id', 'brand_name', 'price')->get();;
                $tmtweight = Tmtdetail::find($product->thickness_id);
                $product->weight = $tmtweight->weight;
                $product->brands = $brands;
                $product->is_wishlist = in_array($product->id, $wislist);
            } else if ($product->category_id == 2) {


                $p = CategoryPrice::where('category_id', $product->category_id)->first();
                $product->category_price = $p->price;
                $product->attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'height',  'price')->get();


                $product->is_wishlist = in_array($product->id, $wislist);
            } else if ($product->category_id == 3) {

                $p = CategoryPrice::where('category_id', $product->category_id)->first();
                $product->category_price = $p->price;
                $product->attributes = ProductAttribute::join('roofing_thicknesses', 'roofing_thicknesses.id', 'product_attributes.thickness')
                    ->where('product_id', $product->id)->select('product_attributes.id', 'roofing_thicknesses.thickness',  'price', 'formula_value')->get();

                $product->colors = RoofingColor::where('status', true)->get();


                $product->is_wishlist = in_array($product->id, $wislist);
            } else {

                if ($product->subcategory_id) {
                    $subcategory = Subcategory::find($product->subcategory_id);
                    $product->subcategory = $subcategory->subcategory_name;
                }
                $p = CategoryPrice::where('category_id', $product->category_id)->first();
                $product->category_price = $p->price;

                $product->attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'thickness', 'weight', 'price')->get();


                $product->is_wishlist = in_array($product->id, $wislist);
            }
        }

        return $products;
    }

    public function search(Request $request)
    {

        $products = Product::where('status', true)->where('product_name', 'like', '%' . $request->search . '%')->select(
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
            'thickness_id'
        )->get();

        return view('public.products.index', ['products' => $this->setupProducts($products)]);
    }

    public function category($category)
    {
        $products = Product::join('categories', 'categories.id', 'products.category_id')
            ->where('categories.slug', $category)
            ->where('products.status', 1)
            ->select('products.*')
            ->get();

        foreach ($products as $product) {
            if ($product->category_id == 1) {
                //    return  $product->brand;
                $new_brands = explode(',', $product->brand);
                // return $new_brands;
                $product->brands = Brand::whereIn('id', $new_brands)->get();
            } else {
                $product->thick = ProductAttribute::where('product_id', $product->id)->get();
                $basePrice = Pricesetting::where('cat_id', $product->category_id)->value('price');
                $product->basePrice = $basePrice;
                // return $product->thick;
            }
        }
        return view('products.index', ['products' => $products]);
    }

    public function subcategory($category, $subcategory)
    {
        $products = Product::join('categories', 'categories.id', 'products.category_id')
            ->leftJoin('subcategories', 'subcategories.id', 'products.subcategory_id')
            ->where('categories.slug', $category)
            ->where('subcategories.slug', $subcategory)
            ->where('products.status', 1)
            ->select('products.*')
            ->get();

        foreach ($products as $product) {
            if ($product->category_id == 1) {
                //    return  $product->brand;
                $new_brands = explode(',', $product->brand);
                // return $new_brands;
                $product->brands = Brand::whereIn('id', $new_brands)->get();
            } else {
                $product->thick = ProductAttribute::where('product_id', $product->id)->get();
                $basePrice = Pricesetting::where('cat_id', $product->category_id)->value('price');
                $product->basePrice = $basePrice;
                // return $product->thick;
            }
        }
        return view('products.index', ['products' => $products]);
    }
}
