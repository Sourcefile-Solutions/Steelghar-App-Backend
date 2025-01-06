<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPrice;
// use App\Models\Cart;
// use App\Models\Cartproduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Public\Cart;
use App\Models\Public\Cartproduct;
use App\Models\RoofingColor;
use App\Models\Subcategory;
use App\Models\Tmtdetail;
use App\Traits\CartTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use CartTrait;



    public function index()
    {
        $cart = $this->checkChart();


        $cartProducts = Cartproduct::where('cart_id', $cart->id)
            ->join('products', 'cartproducts.product_id', 'products.id')
            ->select('cartproducts.*')
            ->latest()
            ->get();

// return $cartProducts;

        list($cartData, $amountCalculation) = $this->cartCalculation($cartProducts);

        return view(
            'public.cart.index',
            [
                'cartProducts' => $cartData,
                'amountCalculation' => $amountCalculation
            ]
        );
    }

    protected function checkChart()
    {
        return Cart::firstOrCreate(
            ['customer_id' => auth()->user()->id, 'status' => false],
            ['customer_id' => auth()->user()->id]
        );
    }

    public function addToCart(Request $request)
    {

        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $product = Product::find($request->product_id);


        return  match ($product->category_id) {
            1 => $this->addTmtProduct($request),
            2 => $this->addMeshProduct($request),
            3 => $this->addRoofProduct($request),
            default => $this->addCrProduct($request),
        };

        return;
    }

    public function removeFromCart(Request $request)
    {
        $cart = Cart::where([['customer_id', auth()->user()->id], ['status', false]])->first();
        $product = Cartproduct::where([['cart_id', $cart->id], ['id', $request->id]])->first();

        if ($product) {
            if ($product->delete()) return 1;
        }
    }

    public function addTmtProduct($request)
    {

        $request->validate([
            'product_id' => 'required',
            'brand_id' => 'required',
            'length' => 'required',
            'weight' => 'required'
        ]);
        $cart = $this->checkChart();
        // Check Product Already in cart
        $already = Cartproduct::where([
            ['cart_id', $cart->id],
            ['product_id', $request->product_id],
            ['brand_id', $request->brand_id]
        ])->first();
        if ($already) return response()->json(['status' => 'error', 'message' => 'product already in cart']);
        $created = Cartproduct::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'brand_id' => $request->brand_id,
            'length' => $request->length,
        ]);
        if ($created) return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
        return response()->json(['status' => 'error', 'message' => 'failed to add to cart']);
    }


    public function addMeshProduct($request)
    {

        $request->validate([
            'product_id' => 'required',
            'product_attribute_id' => 'required|integer',
            'length' => 'required',
        ]);


        $cart = $this->checkChart();
        // // Check Product Already in cart
        $already = Cartproduct::where([
            ['cart_id', $cart->id],
            ['product_id', $request->product_id],
            ['product_attribute_id', $request->product_attribute_id]
        ])->first();
        if ($already) return response()->json(['status' => 'error', 'message' => 'product already in cart']);
        $created = Cartproduct::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'product_attribute_id' => $request->product_attribute_id,
            'length' => $request->length,
        ]);
        if ($created) return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
        return response()->json(['status' => 'error', 'message' => 'failed to add to cart']);
    }

    public function addRoofProduct($request)
    {
        $request->validate([
            'product_id' => 'required',
            'product_attribute_id' => 'required|integer',
            'no_of_sheet' => 'required',
            'size' => 'required',
            'color' => 'required',
        ]);

        $cart = $this->checkChart();
        // // Check Product Already in cart
        $already = Cartproduct::where([
            ['cart_id', $cart->id],
            ['product_id', $request->product_id],
            ['product_attribute_id', $request->product_attribute_id],
            ['color', $request->color],
            ['size', $request->size]
        ])->first();
        if ($already) return response()->json(['status' => 'error', 'message' => 'product already in cart']);
        $created = Cartproduct::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'product_attribute_id' => $request->product_attribute_id,
            'no_of_sheet' => $request->no_of_sheet,
            'size' =>  $request->size,
            'color' =>  $request->color,
        ]);
        if ($created) return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
        return response()->json(['status' => 'error', 'message' => 'failed to add to cart']);
    }


    public function addCrProduct($request)
    {


        $request->validate([
            'product_id' => 'required',
            'product_attribute_id' => 'required|integer',
            'length' => 'required',
            'weight' => 'required'
        ]);




        $cart = $this->checkChart();
        // // Check Product Already in cart
        $already = Cartproduct::where([
            ['cart_id', $cart->id],
            ['product_id', $request->product_id],
            ['product_attribute_id', $request->product_attribute_id]
        ])->first();
        if ($already) return response()->json(['status' => 'error', 'message' => 'product already in cart']);
        $created = Cartproduct::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'product_attribute_id' => $request->product_attribute_id,
            'length' => $request->length,
        ]);
        if ($created) return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
        return response()->json(['status' => 'error', 'message' => 'failed to add to cart']);
    }


    public function update(Request $request, Cartproduct  $cartproduct)
    {
        $cart = Cart::where('id', $cartproduct->cart_id)->first();
        if (!$cart) return response()->json(['status' => 'error', 'message' => 'cart not found']);
        if ($cart->user_id != auth()->user()->id) return response()->json(['status' => 'error', 'message' => 'Invalid']);
        $validated = $request->validate([
            'weight' => 'required',
            'length' => 'required',
        ]);
        $updated = $cartproduct->update($validated);
        if ($updated)  return response()->json(['message' => 'Cart Updated successfully!', 'title' => 'Update', 'status' => 'success'], 201);
        return response()->json(['message' => 'Failed to update cart', 'title' => 'Failed', 'status' => 'error'], 200);
    }


    public function destroy($id)
    {
        $cartitem = Cartproduct::where('id', $id)->first();

        if (!$cartitem) {
            return response()->json(['error' => 'Item not found in cart'], 404);
        }

        $cartitem->delete();
        return response()->json(['message' => 'Item Removed From Your Cart']);
    }

    public function getCartCount()
    {
        $cartCount = 0;

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::user()->id)
                ->where('status', false)
                ->first();

            if ($cart) {
                $cartCount = CartProduct::where('cart_id', $cart->id)->count();
            }
        }

        return response()->json(['cartCount' => $cartCount]);
    }


    public function edit(Request $request)
    {


        $cartProduct = Cartproduct::find($request->id);


        if (!$cartProduct) return 0;

        $product = Product::find($cartProduct->product_id);

        $view = match ($product->category_id) {
            1 => $this->tmtEditView($product, $cartProduct),
            2 => $this->meshEditView($product, $cartProduct),
            3 => $this->roofEditView($product, $cartProduct),
                // 'get', 'head' =>  $this->handleGet(),
            default => $this->otherEditView($product, $cartProduct),
        };

        return response()->json(['status' => 'success', 'edit' => $view]);
        // return  ;
    }


    protected function tmtEditView($product, $cartProduct)
    {
        $brands = Brand::whereIn('id', json_decode($product->brand))->where('status', true)->select('id', 'brand_name', 'price')->get();;

        $tmtweight = Tmtdetail::find($product->thickness_id);

        $brandPrice = $brands->where('id', $cartProduct->brand_id)->pluck('price')->first();;

        $price = $brandPrice * $tmtweight->weight * $cartProduct->length;


        return view('public.cart.edit.tmt', [
            'tmtweight' => $tmtweight->weight,
            'brands' => $brands,
            'product' => $product,
            'cartProduct' => $cartProduct,
            'price' => $price
        ])->render();
    }


    protected function meshEditView($product, $cartProduct)
    {
        $p = CategoryPrice::where('category_id', $product->category_id)->first();
        $attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'height',  'price')->get();
        $attiributePrice = $attributes->where('id', $cartProduct->product_attribute_id)->pluck('price')->first();;
        $attiributeHeight = $attributes->where('id', $cartProduct->product_attribute_id)->pluck('height')->first();;
        return view('public.cart.edit.mesh', [
            'categoryPrice' => $p->price,
            'attributes' => $attributes,
            'product' => $product,
            'cartProduct' => $cartProduct,
            'price' => $attiributeHeight * ($p->price + $attiributePrice)
        ])->render();
    }

    protected function roofEditView($product, $cartProduct)
    {
        $p = CategoryPrice::where('category_id', $product->category_id)->first();

        // $attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'thickness',  'price')->get();

        $attributes = ProductAttribute::join('roofing_thicknesses', 'roofing_thicknesses.id', 'product_attributes.thickness')
            ->where('product_id', $product->id)
            ->select('product_attributes.id', 'roofing_thicknesses.thickness',  'price', 'formula_value')->get();



        $attiributePrice = $attributes->where('id', $cartProduct->product_attribute_id)->select('price', 'formula_value')->first();;
        $colors = RoofingColor::where('status', true)->get();
        return view('public.cart.edit.roof', [
            'categoryPrice' => $p->price,
            'attributes' => $attributes,
            'product' => $product,
            'cartProduct' => $cartProduct,
            'colors' => $colors,
            'price' => ($attiributePrice['formula_value'] * ($p->price + $attiributePrice['price'])) * $cartProduct->size * $cartProduct->no_of_sheet
        ])->render();
    }


    protected function otherEditView($product, $cartProduct)
    {


        $p = CategoryPrice::where('category_id', $product->category_id)->first();

        $attributes = ProductAttribute::where('product_id', $product->id)->select('id', 'thickness', 'weight', 'price')->get();
        $attributesWeight = $attributes->where('id', $cartProduct->product_attribute_id)->pluck('weight')->first();;
        $attributesPrice = $attributes->where('id', $cartProduct->product_attribute_id)->pluck('price')->first();;
        return view('public.cart.edit.other', [
            'categoryPrice' => $p->price,
            'attributes' => $attributes,
            'product' => $product,
            'cartProduct' => $cartProduct,
            'weight' =>  $cartProduct->length * $attributesWeight,
            'price' => (($cartProduct->length * $attributesWeight) * ($p->price + $attributesPrice))
        ])->render();
    }

    public function updateToCart(Cartproduct $product, Request $request)
    {
        $p = Product::find($product->product_id);
        if ($p->category_id == 1) {
            $validated = $request->validate([
                'brand_id' => 'required|integer',
                'length' => 'required|string'
            ]);
        } else if ($p->category_id == 2) {
            $validated = $request->validate([
                'product_attribute_id' => 'required|integer',
                'length' => 'required|string'
            ]);
        } else if ($p->category_id == 3) {
            $validated = $request->validate([
                'size' => 'required',
                'no_of_sheet' => 'required',
                'product_attribute_id' => 'required',
                'color' => 'required'
            ]);
        } else {
            $validated = $request->validate([
                'length' => 'required|string',
                'product_attribute_id' => 'required',
            ]);
        }
        $updated =  $product->update($validated);
        if ($updated) return response()->json(['status' => 'success', 'message' => 'Cart Updated Successfully!']);
        return response()->json(['status' => 'error', 'message' => 'Failed to update Cart!']);
    }
}