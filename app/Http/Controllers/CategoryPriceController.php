<?php

namespace App\Http\Controllers;

use App\Models\CategoryPrice;
use Illuminate\Http\Request;

class CategoryPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = CategoryPrice::join('categories', 'categories.id', 'category_prices.category_id')->select('category_prices.*', 'category_name')->get();
        return view('console.category.price', ['prices' => $prices]);
    }




    public function update(Request $request, CategoryPrice $category_price)
    {


        $validated = $request->validate([
            'price' => 'required'
        ]);

        $updated = $category_price->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryPrice $category_price)
    {
        //
    }

    public function getBasePrice($id)
    {
        // Retrieve the base price for the given category ID
        $basePrice = CategoryPrice::where('cat_id', $id)->value('price');

        // Check if base price is found
        if ($basePrice !== null) {
            return response()->json(['basePrice' => $basePrice], 200);
        } else {
            return response()->json(['message' => 'Base price not found for the selected category.'], 404);
        }
    }

    public function pricing()
    {
        // return Pricesetting::select('cat_id')->get();
        return CategoryPrice::where('cat_id', 7)->value('price');
    }
}
