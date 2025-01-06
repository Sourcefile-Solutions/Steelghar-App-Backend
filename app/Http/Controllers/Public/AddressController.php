<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Public\Address;
// use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        // $address = Address::where('user_id', auth()->user()->id)->get();
        // return view('address.address', ['address' => $address]);
    }

    public function addaddress()
    {
        return view('address.newaddress');
    }

    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'phone' => 'required|digits:10',
            'address' => 'required|string|max:1000',
            'address_2' => 'required|string|max:1000',
            'land_mark' => 'nullable|string|max:1000',
            'city' => 'required|string|max:250',
            'state' => 'required|string|max:250',
            'pincode' => 'required|digits:6',
        ]);


        $validated['customer_id'] = auth()->user()->id;

        $created = Address::create($validated);

        if ($created) return redirect()->back();

        return redirect()->back();
    }
    public function editAddress(Address $address, $id)
    {
        $address = Address::where([['id', $id]])->first();
        return view('address.editaddress', ['address' => $address]);
    }
    public function updateAddress(Request $request, $id)
    {

        $validated = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string',
            'phone' => 'required|integer',
            'address' => 'nullable|string',
            'address2' => 'nullable|string',
            'landmark' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|integer',
        ]);
        // return $validated;
        $address = Address::find($id);
        $update = $address->update($validated);

        if ($update) {
            return redirect('/address')->with('success', 'Address updated successfully.');
        }
    }

    public function destroyAddress($id)
    {
        $del = Address::find($id);
        $del->delete();
        return redirect()->back();
    }

    public function myProfile()
    {
        $myprofile = Address::where('user_id', auth()->user()->id)->get();

        return view('editprofile', ['myprofile' => $myprofile]);
        // return $myprofile;
    }

    public function profileUpdate(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $validated = $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|min:10',

        ]);

        $create = $user->update($validated);
        if ($create) return redirect()->back()->with('success', 'Updated Successfully');
        else {
            return response()->json(['error' => 'Something went wroong try again later'], 450);
        }
    }
}
