<?php

namespace App\Http\Controllers;

use App\Models\Product;
//use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET: Get all products
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Product retrieved successfully',
            'data' => $products
        ], 200);
    }
    // GET: Get product by ID
    function search($id){
        $product = Product::find($id);
        if($product === null){
            return response()->json(
                [
                    'status'=>'error',
                    'message'=>'Product not found',
                    'data'=>[]
                ],404
            );
        }
        return response()->json(
            [
                'status'=>'success',
                'message'=>'Product retrieved successfully',
                'data'=>$product
            ], 200
        );
    }
    // POST: Create product
    public function store(Request $request){
        $data = $request->validate([
        'name'=>'required|string|max:255',
        'slug'=>'required|string|unique:products,slug',
        'sku'=>'required|string|unique:products,sku',
        'category_id'=>'nullable|integer|exists:categories,id',
        'brand_id'=>'nullable|integer|exists:brands,id',
        'description'=>'nullable|string',
        'material'=>'nullable|string',
        'max_load_kg'=>'nullable|numeric',
        'recline_angle'=>'nullable|string',
        'has_footrest'=>'boolean',
        'has_lumbar_pillow'=>'boolean',
        'has_headrest_pillow'=>'boolean',
        'armrest_type'=>'nullable|string',
        'base_price'=>'required|numeric',
        'sale_price'=>'nullable|numeric'
        ]);
        $product = Product::create($data);
        return response()->json(
            [
                'status'=>'success',
                'message'=>'Product created successfully!!',
                'data'=> $product
            ], 201
        );
    }
    // PUT/PATCH: Update product
    public function update(Request $request, $id){
        $product = Product::find($id);
        if($product === null){
            return response()->json(
                [
                    'status'=>'error', 
                    'message'=>'Product not found',
                    'data'=>[]
                ],404
            );
        }
        $data = $request->validate([
        'name'=>'sometimes|required|string|max:255',
        'slug'=>'sometimes|required|string|unique:products,slug,'. $id,
        'sku'=>'sometimes|required|string|unique:products,sku,'. $id,
        'category_id'=>'nullable|integer|exists:categories,id',
        'brand_id'=>'nullable|integer|exists:brands,id',
        'description'=>'nullable|string',
        'material'=>'nullable|string',
        'max_load_kg'=>'nullable|numeric',
        'recline_angle'=>'nullable|string',
        'has_footrest'=>'boolean',
        'has_lumbar_pillow'=>'boolean',
        'has_headrest_pillow'=>'boolean',
        'armrest_type'=>'nullable|string',
        'base_price'=>'sometimes|required|numeric',
        'sale_price'=>'nullable|numeric'
        ]);
        $product->update($data);
        return response()->json(
            [
                'status'=>'success',
                'message'=>'Product Updated successfully!!!!', 
                'data'=>$product
            ],200
        );
    }
    // DELETE: Delete product
    function destroy( $id){
        $product = Product::find($id);
        if($product === null){
            return response()->json([
               'status'=>'error',
               'message'=>'Product not found',
                'data'=>[]
            ],404);
        }
        $product->delete();
        return response()->json([
                'status'=>'success',
                'message'=>'Product Deleted Successfully!!!!'
            ],200);
    }
}
