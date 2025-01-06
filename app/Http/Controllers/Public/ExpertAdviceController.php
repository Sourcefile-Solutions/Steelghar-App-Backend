<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpertAdvice;

class ExpertAdviceController extends Controller
{
    public function index()
    {
      return view('expert_advice_form');
    }

  public function store(Request $request)
{
    // Validate the form data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'message' => 'required|string|max:500',
    ]);

      ExpertAdvice::create($validated);

    // Return a success response
    return response()->json(['success' => 'Message sent successfully!'], 200);
}
}
