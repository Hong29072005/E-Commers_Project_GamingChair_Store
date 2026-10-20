<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    // GET: Show all cart items
    public function show()
    {
        $cartItems = CartItem::with(['cart', 'product', 'variant'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart items retrieved successfully',
            'data' => $cartItems
        ], 200);
    }

    // GET: Search cart item by ID
    public function search($id)
    {
        $cartItem = CartItem::with(['cart', 'product', 'variant'])->find($id);

        if ($cartItem === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found!!!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cart item retrieved successfully',
            'data' => $cartItem
        ], 200);
    }

    // POST: Create / Add item to cart
    public function store(Request $request)
    {
        $data = $request->validate([
            'cart_id'    => 'required|integer|exists:carts,id',
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'quantity'   => 'required|integer|min:1',
            'added_at'   => 'nullable|date',
        ]);

        // ប្រសិនបើ Front-end មិនបានផ្ញើ added_at មកទេ ឱ្យ Back-end ចាប់យកម៉ោងបច្ចុប្បន្នស្វ័យប្រវត្តិ
        $data['added_at'] = $data['added_at'] ?? now();

        // ពិនិត្យមើលថា តើ Product/Variant នេះមានក្នុង Cart រួចហើយឬនៅ?
        $existingItem = CartItem::where('cart_id', $data['cart_id'])
            ->where('product_id', $data['product_id'])
            ->where('variant_id', $data['variant_id'] ?? null)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $data['quantity'];
            $existingItem->added_at = $data['added_at']; // Update ម៉ោងបន្ថែមចុងក្រោយ
            $existingItem->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Cart item quantity updated successfully!!!',
                'data'    => $existingItem->load(['cart', 'product', 'variant'])
            ], 200);
        }

        $cartItem = CartItem::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Item added to cart successfully!!!',
            'data'    => $cartItem->load(['cart', 'product', 'variant'])
        ], 201);
    }

    // PUT: Update cart item
    public function update(Request $request, $id)
    {
        $cartItem = CartItem::find($id);

        if ($cartItem === null) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Cart item not found!!!',
                'data'    => []
            ], 404);
        }

        $data = $request->validate([
            'cart_id'    => 'required|integer|exists:carts,id',
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'quantity'   => 'required|integer|min:1',
            'added_at'   => 'nullable|date',
        ]);

        $cartItem->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Cart item updated successfully!!!!',
            'data'    => $cartItem->load(['cart', 'product', 'variant'])
        ], 200);
    }

    // DELETE: Remove item from cart
    public function destroy($id)
    {
        $cartItem = CartItem::find($id);

        if ($cartItem === null) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Cart item not found!!!',
                'data'    => []
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Cart item deleted successfully!!!!'
        ], 200);
    }
}
