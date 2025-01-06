<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Public\ExpertAdvice;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $testimonials = Testimonial::where('status', true)->latest()->get();
        return view('public.pages.about', ['testimonials' => $testimonials]);
    }

    public function expertAdvice()
    {
        return view('public.pages.expert-advice');
    }

    public function calculator()
    {
        return view('public.pages.calculator');
    }

    public function contact()
    {
        return view('public.pages.contact');
    }

    public function brands()
    {
        $brands = Brand::where('status', true)->latest()->get();
        return view('public.brands', ['brands' => $brands]);
    }


    public function termsAndConditions()
    {
        return view('public.pages.terms-and-conditions');
    }

    public function returnPolicy()
    {
        return view('public.pages.return-policy');
    }

    public function privacyPolicy()
    {
        return view('public.pages.privacy-policy');
    }


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
            session()->flash('success', 'Expert advice request has been successfully submitted!');
            return redirect()->back();
        }

        session()->flash('error', 'Something went wrong. Please try again.');
        return redirect()->back()->withInput();
    }
}
