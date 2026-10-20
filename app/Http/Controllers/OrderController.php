<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // GET: Get all orders (with Relations)
    function show(){
        $orders = Order::with(['customer', 'items.product', 'shippingAddress'])->latest()->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Order retrieved successfully',
            'data' => $orders
        ], 200);
    }
    // GET: Get order by ID
    function search($id){
        $order = Order::with(['customer', 'items.product', 'shippingAddress', 'billingAddress', 'coupon'])->find($id);
        if($order === null){
            return response()->json([
                'status'=>'error',
                'message'=>'Order not found!!!',
                'data'=>[]
            ],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>'Order retrieved successfully',
            'data'=>$order
        ], 200);
    }
    // POST: Create new order
    function store(Request $request){
        // Auto generate order_number ប្រសិនបើ Front-end មិនបានផ្ញើមក
        if (!$request->has('order_number')) {
            $request->merge(['order_number' => 'ORD-' . strtoupper(Str::random(10))]);
        }
        $data = $request->validate([
            'order_number'        => 'required|string|max:30|unique:orders,order_number',
            'customer_id'         => 'required|integer|exists:customers,id',
            'status'              => 'nullable|string|in:pending,paid,processing,shipped,delivered,cancelled',
            'shipping_address_id' => 'required|integer|exists:addresses,id',
            'billing_address_id'  => 'required|integer|exists:addresses,id',
            'coupon_id'           => 'nullable|integer',
            'subtotal'            => 'required|numeric',
            'discount_amount'     => 'nullable|numeric',
            'shipping_cost'       => 'nullable|numeric',
            'tax_amount'          => 'nullable|numeric',
            'total_amount'        => 'required|numeric',
            'payment_method'      => 'nullable|string|max:50',
            'payment_status'      => 'nullable|string|in:unpaid,paid,failed,refunded',
            'tracking_number'     => 'nullable|string|max:100',
            'notes'               => 'nullable|string'
        ]);
        $order = Order::create($data);
        return response()->json([
            'status'=>'success',
            'message'=>'Order created successfully!!!',
            'data'=>$order
        ],201);
    }
    // PUT: Update order
    function update(Request $request, $id){
        $order = Order::find($id);
        if($order === null){
            return response()->json([
                'status'=>'error',
                'message'=>'Order not found!!!',
                'data'=>[]
            ],404);
        }
        $data = $request->validate([
            'order_number'        => 'sometimes|required|string|max:30|unique:orders,order_number,' . $id,
            'customer_id'         => 'sometimes|required|integer|exists:customers,id',
            'status'              => 'nullable|string|in:pending,paid,processing,shipped,delivered,cancelled',
            'shipping_address_id' => 'required|integer|exists:addresses,id',
            'billing_address_id'  => 'required|integer|exists:addresses,id',
            'coupon_id'           => 'nullable|integer',
            'subtotal'            => 'sometimes|required|numeric',
            'discount_amount'     => 'nullable|numeric',
            'shipping_cost'       => 'nullable|numeric',
            'tax_amount'          => 'nullable|numeric',
            'total_amount'        => 'sometimes|required|numeric',
            'payment_method'      => 'nullable|string|max:50',
            'payment_status'      => 'nullable|string|in:unpaid,paid,failed,refunded',
            'tracking_number'     => 'nullable|string|max:100',
            'notes'               => 'nullable|string'
        ]);
        $order->update($data);
        return response()->json([
            'status'=>'success',
            'message'=>'Order Updated successfully!!!!', 
            'data'=>$order
        ],200);
    }
    // DELETE: Delete order
    function destroy($id){
        $order = Order::find($id);
        if($order === null){
        return response()->json([
            'status'=>'error',
            'message'=>'order not found!!!',
            'data'=>[]
            ],404);
        }
        $order->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Order Deleted Successfully!!!!'
        ],200);
    }
}
