<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function loginPage(Request $request)
    {

        // $host = $request->getHost(); // Get the current host (e.g., 'subdomain.example.com')

        // return  $host;
        // // $hostParts = explode('.', $host); // Split the host into parts
        // // if (count($hostParts) >= 3) {
        // //     $subdomain = $hostParts[0]; // Extract the subdomain (first part)
        // // } else {
        // //     $subdomain = null; // No subdomain
        // // }

        // if ($host == "localhost") return redirect('http://localhost:8000/login');

        $user = User::first();

        if (!$user) return view('console.auth.admin');

        else return view('console.auth.login');
    }


    public function admin(Request $request)
    {

        $already = User::first();

        if ($already) return redirect()->route('login');
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:5',
        ]);


        $validated['password'] = Hash::make($validated['password']);

        $created = User::create($validated);

        if ($created) {

            Setting::create(['site_name' => 'Steel Ghar', 'logo' => '/default/logo.png', 'fav_icon' => '/default/fav-icon.png']);
            return redirect()->route('login');
        }

        return redirect()->back();
    }


    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route('console.home');
    }
    
    
    public function logout(Request $request){
       
    Auth::logout();

   
    $request->session()->invalidate();

   
    $request->session()->regenerateToken();

    
    return redirect('/login');
    }
}
