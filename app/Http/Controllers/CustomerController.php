<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $customer = Customer::create($request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255|unique:customers,phone_number',
            'password' => 'required|string|min:8',
        ]));

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer,
        ], 201);
    }
}
