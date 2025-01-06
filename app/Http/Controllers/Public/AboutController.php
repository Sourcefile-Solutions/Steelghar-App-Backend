<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('status', 1)->get();
        // return $testimonials;
        return view('about', ['testimonials' => $testimonials]);
    }
}
