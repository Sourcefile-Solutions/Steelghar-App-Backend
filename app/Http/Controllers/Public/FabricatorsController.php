<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Fabircator;
use Illuminate\Http\Request;

class FabricatorsController extends Controller
{
    public function index()
    {
        return view('fabricators',);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required',
            'company_name' => 'required',
            'phone' => 'required|digits:10',
            'email' => 'required',
            'gst' => 'required|regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[A-Z\d]{1}$/',
            'pan' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'aadhaar' => 'required|regex:/^\d{12}$/',
            'business_agreement' => 'required|file|mimes:pdf,docx,doc',
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ], [
            'aadhaar.regex' => 'Aadhar number must be 12 digits.',
            'pan.regex' => 'PAN number must be in the format: ABCDE1234F',
            'gst.regex' => 'GST number must be in the format: 12ABCDE1234F1Z1',
        ]);

        if ($request->business_agreement) {
            $validated['business_agreement'] = $request->file('business_agreement')->storeAs('fabricators', $validated['company_name'] . '-' . str_replace(".", "", microtime(true)) . '.' . $request->file('business_agreement')->getClientOriginalExtension());
        } else {
            $validated['business_agreement'] = 'fabricators/agreement.pdf';
        }

        if ($request->photo) {
            $validated['photo'] = $request->file('photo')->storeAs('fabricators', $validated['company_name'] . '-' . str_replace(".", "", microtime(true)) . '.' . $request->file('photo')->getClientOriginalExtension());
        } else {
            $validated['photo'] = 'fabricators/photo.png';
        }

        $created = Fabircator::create($validated);
        if ($created) {
            return redirect()->back()->with('success', 'Fabricator added successfully');
        }

        return response()->json(['message' => 'Failed to add Banner ' . $request->company_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }
}
