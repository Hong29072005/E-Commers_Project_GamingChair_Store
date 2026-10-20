<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    // GET: Show all product variants
    public function show()
    {
        $productVariants = ProductVariant::with(['product', 'images'])->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product variants retrieved successfully',
            'data'    => $productVariants
        ], 200);
    }

    // GET: Find product variant by ID
    public function search($id)
    {
        
        $productVariants = ProductVariant::with(['product', 'images'])->find($id);

        if (!$productVariants) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product variant not found!',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Product variant retrieved successfully',
            'data'    => $productVariants
        ], 200);
    }

    // POST: Create new product variant
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'       => 'required|integer|exists:products,id',
            'color_name'       => 'required|string|max:50',
            'color_hex'        => ['nullable', 'string', 'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/'],
            'sku'              => 'required|string|max:60|unique:product_variants,sku', 
            'price_adjustment' => 'nullable|numeric',
            'stock_quantity'   => 'required|integer|min:0',
            'is_active'        => 'nullable|boolean'
        ]);

        $productVariants = ProductVariant::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product variant created successfully!',
            'data'    => $productVariants
        ], 201);
    }

    // PUT/PATCH: Update product variant
    public function update(Request $request, $id)
    {
        $productVariants = ProductVariant::find($id);

        if (!$productVariants) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product variant not found!',
                'data'    => null
            ], 404);
        }

        $data = $request->validate([
            'product_id'       => 'required|integer|exists:products,id',
            'color_name'       => 'required|string|max:50',
            'color_hex'        => ['nullable', 'string', 'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/'],
            'sku'              => ['required', 'string', 'max:60', Rule::unique('product_variants', 'sku')->ignore($id)],
            'price_adjustment' => 'nullable|numeric',
            'stock_quantity'   => 'required|integer|min:0',
            'is_active'        => 'nullable|boolean'
        ]);

        $productVariants->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product variant updated successfully!',
            'data'    => $productVariants
        ], 200);
    }

    // DELETE: Remove product variant
    public function destroy($id)
    {
        $productVariants = ProductVariant::find($id);

        if (!$productVariants) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product variant not found!',
                'data'    => null
            ], 404);
        }

        $productVariants->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product variant deleted successfully!'
        ], 200); 
    }
}
