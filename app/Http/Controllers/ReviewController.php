<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // GET: Show all review
    public function show()
    {
        
        $reviews = Review::with(['product', 'customer', 'order'])->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Review retrieved successfully',
            'data'    => $reviews
        ], 200);
    }

    // GET: Search Review  by ID
    public function search($id)
    {
        
        $review = Review::with(['product', 'customer','order'])->find($id);

        if (!$review) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Review  not found!',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Review  retrieved successfully',
            'data'    => $review
        ], 200);
    }
    //Post: Create new review
    public function store(Request $request)
    {
        $data = $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'customer_id' => 'required|integer|exists:customers,id',
        'order_id' => 'required|integer|exists:orders,id',
        'rating' => 'required|numeric|between:1,5',
        'title' => 'required|string',
        'comment' => 'required|string',
        'is_verified_purchase' => 'boolean',
        ]);
        $review = Review::create($data);
         return response()->json([
            'status'  => 'success',
            'message' => 'Review  created successfully!',
            'data'    => $review->load(['product', 'customer','order'])
        ], 201);
    }
    //Put: update review
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Review  not found!',
                'data'    => null
            ], 404);
        }
        $data = $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'customer_id' => 'required|integer|exists:customers,id',
        'order_id' => 'required|integer|exists:orders,id',
        'rating' => 'required|numeric|between:1,5',
        'title' => 'required|string',
        'comment' => 'required|string',
        'is_verified_purchase' => 'boolean',
        ]);
        $review->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Review updated successfully!',
            'data'    => $review->load(['product', 'customer','order'])
        ], 200);
    } 
        // DELETE: Remove review 
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Review  not found!',
                'data'    => null
            ], 404);
        }

        $review->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Review  deleted successfully!'
        ], 200); 
    }
}
