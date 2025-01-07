<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPrice;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\RoofingColor;
use App\Models\Subcategory;
use App\Models\Tmtdetail;
use App\Models\Public\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{


    public function index($category = null, $subcategory = null)
    {

        if ($category && $subcategory) return $this->subcategoryProducts($category, $subcategory);

        else if ($category && !$subcategory) return $this->categoryProducts($category);
    }


    protected function categoryProducts($category)
    {
        $products = Product::where([['status', true], ['category_id', $category]])->select(
            'id',
            'category_id',
            // 'subcategory_id',
            'product_name',

            'product_image',
            'brand',



            'thickness_id',
            'low_price'
        )->latest()->get();


        return response()->json(['status' => 'success', 'products' => $this->setupProducts($products)]);
    }



    protected function subcategoryProducts($category, $subcategory)
    {

        $products = Product::where([['status', true], ['category_id',  $category], ['subcategory_id', $subcategory]])->select(
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
                $product->tmtWeight = $tmtweight->weight;
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



    public function category()
    {

        $categories = Category::where(['status' => true])->select('id as category_id', 'category_name', 'category_image')->get();

        foreach ($categories as $category) {

            $category->count = Product::where('category_id', $category->category_id)->count();
            $category->category_image = 'http://localhost:8000/storage/' . $category->category_image;
        }

        $categories = $categories->filter(function ($category) {
            return $category->count > 0;
        })->values();

        return response()->json(['status' => 'success', 'categories' => $categories]);
    }

    public function subcategory($category_id)
    {

        $subCategories = Subcategory::where([['category_id', $category_id], ['status', true]])->select('id as sub_category_id', 'subcategory_name', 'subcategory_image', 'category_id')->get();

        foreach ($subCategories as $subcategory) {
            $subcategory->count = Product::where([['status', true], ['subcategory_id', $subcategory->sub_category_id]])->count();
            $subcategory->subcategory_image = 'http://localhost:8000/storage/' . $subcategory->subcategory_image;
        }



        $subCategories = $subCategories->filter(function ($subcategory) {
            return  $subcategory->count > 0;
        })->values();

        $products = Product::whereNull('subcategory_id')->where([['status', true]])->where('category_id', $category_id)
            ->select(
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

        return response()->json(['status' => 'success', 'subCategories' => $subCategories, 'products' =>  $this->setupProducts($products)]);
    }


    public function product($sub_category_id)
    {
        $products = Product::whereNotNull('subcategory_id')->where([['status', true]])->where('subcategory_id', $sub_category_id)->select(
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

        return response()->json(['status' => 'success',  'products' =>  $this->setupProducts($products)]);
    }
}
