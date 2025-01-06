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
    
    
    public function productData(Request $request){
      
        
        if($request->subcategory_id) return $this->subCategoryOtherProducts($request->subcategory_id);
        
        if($request->category_id<4){
            return $this->categoryProduct($request->category_id);
        }
     
            return $this->otherProduct($request->category_id);
        
    
    }
    
    private function categoryProduct($id){
       
        
    
    $products=Product::where([['category_id', $id],['status',true]])->get();
    foreach($products as $product){
if($id==1){ 
    
    $product->brands= Brand::where('status', true)->whereIn('id',json_decode($product->brand))->select('id', 'brand_name', 'price')->get();
    
    
                $tmtweight = Tmtdetail::find($product->thickness_id);
                $product->tmtWeight = $tmtweight->weight;
               
    
    
}

else if($id==2) {
    $product->category_price=CategoryPrice::where('category_id',2)->value('price');
    $product->productAttributes=ProductAttribute::where('product_id',$product->id)->select('id','price','height')->get();
}

else if($id==3) {
   
    
     $product->category_price=CategoryPrice::where('category_id',3)->value('price');
                $product->productAttributes = ProductAttribute::join('roofing_thicknesses', 'roofing_thicknesses.id', 'product_attributes.thickness')
                    ->where('product_id', $product->id)->select('product_attributes.id', 'roofing_thicknesses.thickness',  'price', 'formula_value')->get();

                $product->colors = RoofingColor::where('status', true)->get();
}


       
    }
  
    // return $products;
    
  

    //   return $products;
      return response()->json(['status' => 'success', 'data' => $products]);
    }
    
     private function otherProduct($id){
      
        $subCategories=Subcategory::where([['category_id',$id],['status', true]])->get();
       
       $products=Product::where([['category_id', $id],['status',true]])->whereNull('subcategory_id')->get();
       
        foreach($products as $product){
              $product->category_price=CategoryPrice::where('category_id',$id)->value('price');
               

                $product->productAttributes = ProductAttribute::where('product_id', $product->id)->select('id', 'thickness', 'weight', 'price')->get();
         }
         
      return response()->json(['status' => 'success', 'data' => ['subCategories'=>$subCategories,'test'=>'helloo', 'products'=>$products]]);
    }
    
    
    private function subCategoryOtherProducts($id){
         $products=Product::where([['subcategory_id', $id],['status',true]])->get();
         foreach($products as $product){
              $product->category_price=CategoryPrice::where('category_id',$id)->value('price');
               

                $product->productAttributes = ProductAttribute::where('product_id', $product->id)->select('id', 'thickness', 'weight', 'price')->get();
         }
         
        
         
      return response()->json(['status' => 'success', 'data' => $products]);
        
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


    protected function setupProducts($products)
    {


        $wislist = Wishlist::where('customer_id', auth()->user()->id)->first();

        if ($wislist) {
            $ws = $wislist->products;
            if ($ws) $wislist = json_decode($ws);
            else $wislist = [];
        } else $wislist = [];


        foreach ($products as $product) {
            if ($product->category_id == 1) {;
                $brands = Brand::whereIn('id', json_decode($product->brand))->where('status', true)->select('id', 'brand_name', 'price')->get();;
                $tmtweight = Tmtdetail::find($product->thickness_id);
                $product->weight = $tmtweight->weight;
                $product->price_start = number_format($brands->min('price') * $tmtweight->weight, 2, '.', '');
                $product->brands = $brands;
                $product->is_wishlist = in_array($product->id, $wislist);
            } else if ($product->category_id == 2) {


                $p = CategoryPrice::where('category_id', $product->category_id)->first();
                $product->category_price = $p->price;
                $product->attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'height',  'price')->get();
                $low_price = ProductAttribute::where('product_id', $product->id)->orderBy(DB::raw('price * weight'), 'asc')
                    ->first();
                $product->low_price = $low_price->height * ($p->price + $low_price->price);
                $product->is_wishlist = in_array($product->id, $wislist);
            } else if ($product->category_id == 3) {

                $p = CategoryPrice::where('category_id', $product->category_id)->first();
                $product->category_price = $p->price;
                $product->attributes = ProductAttribute::join('roofing_thicknesses', 'roofing_thicknesses.id', 'product_attributes.thickness')
                    ->where('product_id', $product->id)->select('product_attributes.id', 'roofing_thicknesses.thickness',  'price', 'formula_value')->get();

                $product->colors = RoofingColor::where('status', true)->get();
                $low_price = ProductAttribute::where('product_id', $product->id)->orderBy('price', 'asc')
                    ->value('price');
                $product->low_price = ($p->price + $low_price) * 1.3;
                $product->is_wishlist = in_array($product->id, $wislist);
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

                $product->is_wishlist = in_array($product->id, $wislist);
            }
        }

        return $products;
    }
}
