<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'password'     => ['required'],
        ]);

        $customer = Customer::where('phone_number', $request->phone_number)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            $token = $customer->createToken('login')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'invalid credentials'], 401);
    }

    public function me()
    {
        return response()->json(['customer' => auth()->user()]);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logged out successfully']);
    }
}
