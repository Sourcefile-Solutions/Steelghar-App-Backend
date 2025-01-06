<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $userId = auth()->user()->id;


        $validated = $request->validate([
            'name' => 'string|required|max:250',
            'phone' => 'required|digits:10|unique:customers,phone,' . $userId,
            'email' => 'required|email|max:200|unique:customers,email,' . $userId,
        ]);


        $customer = Customer::find($userId);


        if (!$customer) {
            return response()->json(['status' => 'error', 'action' => 'logout', 'message' => 'Customer not found.']);
        }


        $update = $customer->update($validated);

        if ($update) return response()->json(['status' => 'success', 'message' => 'Customer details updated successfully.']);


        return response()->json(['status' => 'error', 'message' => 'Failed to update customer details.'], 500);
    }
}
