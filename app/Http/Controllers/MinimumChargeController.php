<?php

namespace App\Http\Controllers;

use App\Models\MinimumCharge;
use Illuminate\Http\Request;

class MinimumChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $charges = MinimumCharge::get();
        return view('console.delivery.index', ['charges' => $charges]);
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



    public function update(Request $request, $id)
    {
        $minimumCharge = MinimumCharge::find($id);
        $validated = $request->validate([
            'from_kg' => 'required|integer',
            'to_kg' => 'required|integer',
            'from_km' => 'required|integer',
            'to_km' => 'required|integer',
            'minimum_charge' => 'nullable|integer',
            'additional_km' => 'nullable|integer',
            'additional_charge' => 'nullable|integer',
        ]);



        $updated = $minimumCharge->update($validated);

        if ($updated) return response()->json(['status' => 'success', 'title' => 'Updated!', 'message' => 'Charges Updated Successfully']);
        return response()->json(['status' => 'error', 'title' => 'Failed!', 'message' => 'Failed to Updated Charges']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MinimumCharge $minimumCharge)
    {
        //
    }
}
