<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
// use App\Models\Public\Customer;
use App\Traits\AppTrait;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    use AppTrait;
    public function login(Request $request)
    {
        // return 123;

        $validated = $request->validate([
            'action' => 'required|string',
            'phone' => 'required|digits:10',
            'otp' => 'required_if:action,otp|digits:4',
        ]);


        if ($validated['action'] === 'phone') {
            $customer = Customer::where([['phone', $validated['phone']], ['is_verified', true]])->first();

            if (!$customer) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.',
                    'action' => 'register'
                ]);
            }

            $customer->otp = 1111;
            // $customer->otp = mt_rand(1000, 9999);
            $customer->save();

            return response()->json([
                'status' => 'success',
                'customer' => $customer->only(['name', 'email', 'phone', 'fcm_token']),
                'action' => 'otp',
            ]);
        } else if ($validated['action'] === 'otp') {
            $customer = Customer::where([
                ['phone', $validated['phone']],
                ['otp', $validated['otp']],
            ])->first();

            if (!$customer) {
                return throw ValidationException::withMessages([
                    'otp' => ['Unprocessable entity, invalid OTP.'],
                ]);
            }

            if (!$customer->is_verified) {
                $customer->is_verified = true;
                $customer->save();
            }

            return response()->json([
                'status' => 'success',
                'token' => $customer->createToken('steel-ghar', ['role:customer'])->plainTextToken,
                'homeData' => $this->homeData($customer->id),
                'action' => 'home'
            ]);
        }




        return response()->json([
            'status' => 'error',
            'message' => 'Invalid action.',
        ]);
    }


    public function resendOtp(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|digits:10',
        ]);

        $customer = Customer::where(
            'phone',
            $validated['phone']

        )->first();

        if (!$customer) return response()->json([
            'status' => 'error',
            'message' => 'User not found.',
            'action' => 'register'
        ]);

        return response()->json([
            'status' => 'success',
            'customer' => $customer->only(['name', 'email', 'phone', 'fcm_token']),
            'action' => 'otp',
        ]);
    }


    public function register(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'phone' => 'required|digits:10',
        ]);

        $already = Customer::where([['phone', $validated['phone']], ['is_verified', true]])->first();

        if ($already) return response()->json(['status' => 'error', 'message' => 'Phone Number Already Exist', 'action' => 'login']);

        $validated['otp'] = 1111;
        $created = Customer::create($validated);

        if ($created)  return response()->json([
            'status' => 'success',
            'customer' => $created->only(['name', 'email', 'phone', 'fcm_token']),
            'action' => 'otp',
        ]);


        return response()->json(['status' => 'error', 'message' => 'Invalid action!']);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'success']);
    }
}
