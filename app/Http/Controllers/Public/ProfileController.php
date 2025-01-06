<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Public\Address;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('public.profile.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'nullable|email|unique:customers,email,' . auth()->user()->id,
            'phone' => 'required|digits:10|unique:customers,phone,' . auth()->user()->id,
        ]);

        $customer = Customer::find(auth()->user()->id);
        $updated = $customer->update($validated);

        if ($updated) return redirect()->back()->with('success', 'Profile Updated Successfully');
        else {
            return response()->json(['error' => 'Something went wroong try again later'], 450);
        }
    }


    public function address()
    {
        $addressess = Address::where('customer_id', auth()->user()->id)->latest()->get();
        return view('public.profile.address.index', ['addressess' => $addressess]);
    }

    public function addressStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'phone' => 'required|digits:10',
            'address' => 'required|string|max:500',
            'address_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:100',
            'pincode' => 'required|digits:6',
            'land_mark' => 'nullable|string|max:250',
            'alternate_phone' => 'nullable|digits:10',
            'is_default' => 'nullable|boolean'
        ]);

        $already = Address::where([['customer_id', auth()->user()->id], ['is_default', true]])->first();

        $validated['customer_id'] = auth()->user()->id;

        if (!$already) $validated['is_default'] = true;


        $created = Address::create($validated);

        if ($created) {
            if ($created->is_default && $already && $already->is_default) {
                $already->is_default = false;
                $already->save();
            }

            if ($created) return redirect()->route('public.profile.address')->with('success', 'Address Added Successfully');
        }

        return redirect()->back()->with('success', 'Failed to add New Address');
    }

    public function addressCreate()
    {
        return view('public.profile.address.create');
    }

    public function addressEdit(Address $address)
    {
        return view('public.profile.address.edit', ['address' => $address]);
    }

    public function addressUpdate(Request $request, Address $address)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'phone' => 'required|digits:10',
            'address' => 'required|string|max:500',
            'address_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:100',
            'pincode' => 'required|digits:6',
            'land_mark' => 'nullable|string|max:250',
            'alternate_phone' => 'nullable|digits:10',
            'is_default' => 'nullable|boolean'
        ]);

        $already = Address::where([['customer_id', auth()->user()->id], ['is_default', true]])->first();


        $updated = $address->update($validated);

        if ($updated) {
            if ($address->is_default && $already && $already->is_default) {
                $already->is_default = false;
                $already->save();
            }

            if ($updated) return redirect()->route('public.profile.address')->with('success', 'Address uPDATED Successfully');
        }

        return redirect()->back()->with('success', 'Failed to Update Address');
    }

    public function addressDelete(Address $address)
    {
        if ($address->is_default) {
            $defaultAddress = Address::where('customer_id', auth()->user()->id)->whereNot('id', $address->id)->latest()->first();
            if ($defaultAddress) {
                $defaultAddress->is_default = true;
                $defaultAddress->save();
            }
        }

        $deleted = $address->delete();

        if ($deleted) return redirect()->back()->with('success', 'Address Deleted  Successfully');
        return redirect()->back()->with('success', 'Failed to  Deleted  address');
    }
}
