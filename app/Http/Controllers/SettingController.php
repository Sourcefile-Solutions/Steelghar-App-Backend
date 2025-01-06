<?php

namespace App\Http\Controllers;

use App\Models\Pricesetting;
use App\Models\Product;
use App\Models\Productattribute;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{


    public function index()
    {
        $setting = Setting::first();
        return view('console.settings.index', ['settings' => $setting]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:25',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'fav_icon'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'phone' => 'nullable|digits:10',
            'phone2' => 'nullable|digits:10',
            'email' => 'nullable|email|max:30',
            'address' => 'nullable|string|max:250',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|digits:6',
            'whatsapp' => 'nullable|digits:10',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'pinterest' => 'nullable|url',
            'youtube' => 'nullable|url',
            'site_mode' => 'nullable|string',
            'vendor_mode' => 'nullable|string',
            'teachnician_mode' => 'nullable|string',
            'seo_keywords' => 'nullable|string|max:250',
            'seo_description' => 'nullable|string|max:200',
        ]);

        if ($request->logo) {
            $validated['logo'] = $request->file('logo')->storeAs('images', 'logo.' . $request->file('logo')->getClientOriginalExtension());
        } else $validated['logo'] = 'images/logo.png';

        if ($request->fav_icon) {
            $validated['fav_icon'] = $request->file('fav_icon')->storeAs('images', 'fav-icon.' . $request->file('fav_icon')->getClientOriginalExtension());
        } else $validated['fav_icon'] = 'images/fav-icon.png';

        $updated = $setting->update($validated);
        if ($updated) {
            return redirect()->back()->with(['message' => 'Settings updated successfully!', 'status' => 'success', 'title' => 'Updated!'], 201);
        }
        return response()->json(['message' => 'Failed to update settings', 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function updatePrice(Request $request, $ps)
    {
        $priceSetting = Pricesetting::find($ps);
        $validated = $request->validate([
            'price' => 'required|numeric',
        ]);

        $updated = $priceSetting->update($validated);
        if ($updated) {
            $products = Productattribute::join('products', 'products.id', 'productattributes.product_id')
                ->where('category_id', $priceSetting->cat_id)
                ->select('productattributes.id', 'price')
                ->get();

            foreach ($products as $product) {
                $newPriceKg = $priceSetting->price + $product->price;
                $product = Productattribute::where('id', $product->id)->first();
                $product->update([
                    'price_kg' => $newPriceKg
                ]);
            }
            return redirect()->back()->with(['message' => 'Price updated successfully!', 'status' => 'success', 'title' => 'Updated!'], 201);
        }

        return response()->json(['message' => 'Failed to update price', 'status' => 'error', 'title' => 'Failed!'], 200);
    }
}
