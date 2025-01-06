<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function loginPage()
    {
        return view('public.auth.login');
    }

    public function registerPage()
    {
        return view('public.auth.register');
    }

    public function login(Request $request)
    {
        $validated = $request->validate(['phone' => 'required|digits:10']);
        $customer = Customer::where([['phone', $validated['phone']], ['is_verified', true]])->first();
        if (!$customer) return response()->json(['status' => 'error', 'message' => 'User not found with this number! Please register first']);
        $customer->otp = 123456;
        // $customer->otp = random_int(123456, 987654);
        if ($customer->save()) return response()->json(['status' => 'success', 'message' => 'Otp sent to your registered phone number']);
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'phone' => 'required|digits:10'
        ]);

        $already = Customer::where('phone', $validated['phone'])->first();

        if ($already && $already->is_verified) return response()->json(['status' => 'error', 'message' => 'Number Alredy registered! Please login']);

        $validated['otp'] = 123456;
        if ($already) $created = $already->update($validated);
        else $created = Customer::create($validated);
        if ($created) return response()->json(['status' => 'success', 'message' => 'Registered Successfully!']);

        return response()->json(['status' => 'error', 'message' => 'Failed!']);
    }

    public function OtpVerify(Request $request)
    {
        $validated = $request->validate(['otp' => 'required|digits:6']);
        $customer = Customer::where([['phone', $request->phone], ['otp', $validated['otp']]])->first();
        if (!$customer) return response()->json(['status' => 'error', 'message' => 'Invalid OTP!']);

        $auth = Auth::guard('customer')->login($customer);
        info($auth);
        $customer->otp = null;
        if ($request->register)  $customer->is_verified = true;
        $saved = $customer->save();

        if ($saved) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed!']);
    }

    public function logout()
    {

        Auth::guard('customer')->logout();
        return redirect('/');
    }
}
