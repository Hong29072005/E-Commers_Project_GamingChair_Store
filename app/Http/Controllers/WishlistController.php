<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WishlistController extends Controller
{
    // GET: Show all wishlists
    public function show()
    {
        
        $wishlists = Wishlist::with(['customer', 'product'])->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Wishlist retrieved successfully',
            'data'    => $wishlists
        ], 200);
    }

    // GET: Search wishlist item by ID
    public function search($id)
    {
        
        $wishlists = Wishlist::with(['customer', 'product'])->find($id);

        if (!$wishlists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Wishlist not found!',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Wishlist  retrieved successfully',
            'data'    => $wishlists
        ], 200);
    }

    // POST: Create new wishlist item
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'product_id'  => [
                'required',
                'integer',
                'exists:products,id',
                // បន្ថែម unique check ដើម្បីកុំឲ្យស្ទួន Customer + Product ដូចគ្នា
                Rule::unique('wishlists')->where(function ($query) use ($request) {
                    return $query->where('customer_id', $request->customer_id);
                }),
            ],
        ], [
            'product_id.unique' => 'This product is already in the customer\'s wishlist.'
        ]);

        $wishlists = Wishlist::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Wishlist  created successfully!',
            'data'    => $wishlists
        ], 201);
    }

    // PUT/PATCH: Update wishlist
    public function update(Request $request, $id)
    {
        $wishlists = Wishlist::find($id);

        if (!$wishlists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Wishlist  not found!',
                'data'    => null
            ], 404);
        }

        $data = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'product_id'  => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('wishlists')->where(function ($query) use ($request) {
                    return $query->where('customer_id', $request->customer_id);
                })->ignore($id),
            ],
        ]);

        $wishlists->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Wishlist updated successfully!',
            'data'    => $wishlists
        ], 200);
    }

    // DELETE: Remove wishlist item
    public function destroy($id)
    {
        $wishlists = Wishlist::find($id);

        if (!$wishlists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Wishlist  not found!',
                'data'    => null
            ], 404);
        }

        $wishlists->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Wishlist  deleted successfully!'
        ], 200); 
    }
}
