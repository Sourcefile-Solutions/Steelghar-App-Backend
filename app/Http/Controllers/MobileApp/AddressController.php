<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\Public\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::where('customer_id', auth()->user()->id)->latest()->get();

        return response()->json(['status' => 'success', 'addresses' => $addresses]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'is_default' => 'required|boolean',
            'name' => 'required|string|max:200',
            'phone' => 'required|digits:10',
            'address' => 'required|string|max:1000',
            'address_2' => 'required|string|max:1000',
            'land_mark' => 'nullable|string|max:250',
            'city' => 'required|string|max:250',
            'state' => 'required|string|max:250',
            'pincode' => 'required|digits:6',
        ]);

        if ($request->id) return $this->update($request, $validated);


        $userId = auth()->user()->id;

        DB::beginTransaction();

        try {

            $validated['customer_id'] = $userId;
            $addressCount = Address::where('customer_id', $userId)->count();
            if ($addressCount === 0)  $validated['is_default'] = true;
            $address = Address::create($validated);
            if ($address->is_default && $addressCount > 0) {
                Address::where('customer_id', $userId)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
            DB::commit();
            $addresses = Address::where('customer_id', $userId)->latest()->get();
            return response()->json(['status' => 'success', 'addresses' => $addresses]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Failed to add address.']);
        }
    }






    public function update($request, $validated)
    {

        $userId = auth()->user()->id;

        DB::beginTransaction();

        try {

            $address = Address::where([['id', $request->id], ['customer_id', $userId]])->first();

            $updated = $address->update($validated);

            if ($updated && $validated['is_default']) {
                Address::where('customer_id', $userId)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            DB::commit();
            $addresses = Address::where('customer_id', $userId)->latest()->get();
            return response()->json(['status' => 'success', 'addresses' => $addresses]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Failed to update address.']);
        }
    }
    
    public function updateDefaultAddress(Request $request)
{
    // return $request;
    $validated = $request->validate([
        'id' => 'required|exists:addresses,id', // Ensure the address ID exists
        'is_default' => 'required|boolean',   // Validate that is_default is a boolean
    ]);

    $userId = auth()->user()->id; // Get the logged-in user ID
    $addressId = $validated['id'];

    DB::beginTransaction();

    try {
        // If the address is set as default, make all other addresses non-default
        if ($validated['is_default']) {
            Address::where('customer_id', $userId)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        // Update the specific address's is_default field
       Address::where('id', $addressId)->update(['is_default' => $validated['is_default']]);
       
       $defaultAddress=Address::where('id', $addressId)->where('is_default',1)->get();
        // return $defaultAddress;

        DB::commit();

        return response()->json(['status' => 'success', 'message' => 'This is Your Default Address Now', 'DefaultAddress'=>$defaultAddress]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Failed to update address.']);
    }
}



    public function destroy($id)
    {
        $address = Address::where([['id', $id], ['customer_id', auth()->user()->id]])->first();

        if (!$address) return response()->json(['status' => 'error', 'message' => 'Address Not Found!']);

        if ($address->delete()) return response()->json(['status' => 'success']);

        return response()->json(['status' => 'error', 'message' => 'Failed to Delete Address']);
    }
}
