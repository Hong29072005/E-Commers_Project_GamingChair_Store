<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Get all carts (ទាញយក Cart ទាំងអស់រួមជាមួយព័ត៌មាន Customer និង Cart Items)
    public function show()
    {
        $carts = Cart::with(['customer', 'items.product', 'items.variant'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Carts retrieved successfully',
            'data' => $carts
        ], 200);
    }

    // Get cart by ID
    public function search($id)
    {
        $cart = Cart::with(['customer', 'items.product', 'items.variant'])->find($id);

        if ($cart === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found!!!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cart retrieved successfully',
            'data' => $cart
        ], 200);
    }

    // Post (Create new Cart)
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'nullable|integer|exists:customers,id|unique:carts,customer_id',
            'session_id'  => 'nullable|string',
        ]);
        if (empty($data['customer_id']) && empty($data['session_id'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Either customer_id or session_id is required.',
            ], 422);
        }
        $cart = Cart::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart created successfully!!!',
            'data' => $cart
        ], 201);
    }

    // Put (Update cart)
    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);

        if ($cart === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found!!!',
                'data' => []
            ], 404);
        }

        $data = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id|unique:carts,customer_id,' . $id,
            'session_id'  => 'nullable|string'
        ]);

        $cart->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart Updated successfully!!!!',
            'data' => $cart
        ], 200);
    }

    // Delete (Remove cart)
    public function destroy($id)
    {
        $cart = Cart::find($id);

        if ($cart === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found!!!',
                'data' => []
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart Deleted Successfully!!!!'
        ], 200);
    }
}
