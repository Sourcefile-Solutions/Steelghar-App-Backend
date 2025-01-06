<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\Public\ExpertAdvice;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function expertAdviceStore(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250',
            'phone' => 'required|digits:10',
            'message' => 'required|string|max:5000'
        ]);

        $created = ExpertAdvice::create($validated);

        if ($created) {
            return response()->json(['status'=>'success', "message"=>'Advice Submitted Successfully']);
            // session()->flash('success', 'Expert advice request has been successfully submitted!');
            // return redirect()->back();
        }

        // session()->flash('error', 'Something went wrong. Please try again.');
        // return redirect()->back()->withInput();

        return response()->json(['status'=>'error', 'message'=>'Failed to save']);
    }
}
