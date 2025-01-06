<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('calculator');
    }
}
