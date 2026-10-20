<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // GET: Show all order items
    public function show()
    {
        $orderItems = OrderItem::with(['order', 'product', 'variant'])->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Order items retrieved successfully!',
            'data'    => $orderItems
        ], 200); 
    }

    // GET: Search order item by ID
    public function search($id)
    {
        $orderItem = OrderItem::with(['order', 'product', 'variant'])->find($id);

        if (!$orderItem) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Order item not found!',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Order item retrieved successfully',
            'data'    => $orderItem
        ], 200);
    }

    // POST: Create new order item
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'      => 'required|integer|exists:orders,id',
            'product_id'    => 'required|integer|exists:products,id', 
            'variant_id'    => 'nullable|integer|exists:product_variants,id',
            'product_name'  => 'required|string|max:255',
            'variant_color' => 'nullable|string|max:50', 
            'unit_price'    => 'required|numeric|min:0',
            'quantity'      => 'required|integer|min:1',
        ]);

        // គណនា line_total ដោយស្វ័យប្រវត្តិ
        $data['line_total'] = $data['unit_price'] * $data['quantity'];

        $orderItem = OrderItem::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Order item created successfully!',
            'data'    => $orderItem->load(['order', 'product', 'variant'])
        ], 201);
    }

    // PUT/PATCH: Update order item
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::find($id);

        if (!$orderItem) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Order item not found!',
                'data'    => null
            ], 404);
        }

        $data = $request->validate([
            'order_id'      => 'sometimes|required|integer|exists:orders,id',
            'product_id'    => 'sometimes|required|integer|exists:products,id',
            'variant_id'    => 'nullable|integer|exists:product_variants,id',
            'product_name'  => 'sometimes|required|string|max:255',
            'variant_color' => 'nullable|string|max:50',
            'unit_price'    => 'sometimes|required|numeric|min:0',
            'quantity'      => 'sometimes|required|integer|min:1',
        ]);

        // គណនា line_total ឡើងវិញ
        $data['line_total'] = $data['unit_price'] * $data['quantity'];

        $orderItem->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Order item updated successfully!',
            'data'    => $orderItem->load(['order', 'product', 'variant'])
        ], 200);
    }

    // DELETE: Remove order item
    public function destroy($id)
    {
        $orderItem = OrderItem::find($id);

        if (!$orderItem) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Order item not found!',
                'data'    => null
            ], 404);
        }

        $orderItem->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Order item deleted successfully!'
        ], 200);
    }
}
