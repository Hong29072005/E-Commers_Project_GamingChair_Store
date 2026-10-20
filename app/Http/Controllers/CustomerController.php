<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // GET: Get all customers
    function show()
    {
        $customers = Customer::all();
        return response()->json([
            'status'=>'success',
            'message'=>'Customer retrieved successfully',
            'data'=>$customers
        ],200);
    }
    // GET: Get customer by ID
    function search($id){
        $customer = Customer::find($id);
        if($customer === null){
            return response()->json([
                'status'=>'error',
                'message'=>'Customer not found!!!',
                'data'=>[]
            ],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>'Customer retrieved successfully',
            'data'=>$customer
        ], 200);
    }
    // POST: Create new customer
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:customers,email',
            'phone'         => 'nullable|string|max:20',
            'password'      => 'required|string|min:8',
            'is_active'     => 'boolean',
        ]);

        // Hash password and map to password_hash
        $data['password_hash'] = Hash::make($data['password']);
        unset($data['password']);

        // Default is_active to true
        $data['is_active'] = $data['is_active'] ?? true;

        $customer = Customer::create($data);

        return response()->json([
            'message' => 'Customer created successfully.',
            'data'    => $customer
        ], 201);
    }
    // PUT: Update customer
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Customer not found!',
                'data'    => null
            ], 404);
        }
        $data = $request->validate([
            'first_name'    => 'sometimes|required|string|max:255',
            'last_name'     => 'sometimes|required|string|max:255',
            'email'         => ['sometimes', 'required', 'email', 'max:255', Rule::unique('customers')->ignore($customer->id)],
            'phone'         => 'nullable|string|max:20',
            'password'      => 'nullable|string|min:8',
            'is_active'     => 'boolean',
        ]);

        // Hash password if provided
        if (!empty($data['password'])) {
            $data['password_hash'] = Hash::make($data['password']);
        }
        unset($data['password']);

        $customer->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Customer updated successfully.',
            'data'    => $customer
        ], 200);
    }
    // DELETE: Remove customer
    public function destroy(Request $request, $id)
    {
        $customer = Customer::find($id);
        
        if($customer === null){
        return response()->json([
            'status'=>'error',
            'message'=>'Customer not found!!!',
            'data'=>[]
            ],404);
        }
        $customer->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'Customer deleted successfully.'
        ], 200);
    }
}
