<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    // GET: Show all product images
    public function show()
    {
        
        $productImages = ProductImage::with(['product', 'variant'])->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product images retrieved successfully',
            'data'    => $productImages
        ], 200);
    }

    // GET: Search product image by ID
    public function search($id)
    {
        
        $productImage = ProductImage::with(['product', 'variant'])->find($id);

        if (!$productImage) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product image not found!',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Product image retrieved successfully',
            'data'    => $productImage
        ], 200);
    }

    // POST: Create new product image
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'image_url'  => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'alt_text'   => 'nullable|string|max:150',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_url')) {
            $imageFile = $request->file('image_url');
            $imageName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            
            // Upload to public/products/images/
            $imageFile->move(public_path('products/images'), $imageName);
            
            $data['image_url'] = 'products/images/' . $imageName;
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        $productImage = ProductImage::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product image uploaded successfully!',
            'data'    => $productImage
        ], 201);
    }

    // PUT/PATCH: Update product image
    public function update(Request $request, $id)
    {
        $productImage = ProductImage::find($id);

        if (!$productImage) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product image not found!',
                'data'    => null
            ], 404);
        }

        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'image_url'  => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'alt_text'   => 'nullable|string|max:150',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image_url')) {
            // Delete old file if exists
            if ($productImage->image_url && file_exists(public_path($productImage->image_url))) {
                unlink(public_path($productImage->image_url));
            }

            $imageFile = $request->file('image_url');
            $imageName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            
            $imageFile->move(public_path('products/images'), $imageName);
            
            $data['image_url'] = 'products/images/' . $imageName;
        } else {
            // ការពារកុំឱ្យ Overwrite image_url ជាមួយ null ពេលមិនបាន Upload File ថ្មី
            unset($data['image_url']);
        }

        $productImage->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product image updated successfully!',
            'data'    => $productImage
        ], 200);
    }

    // DELETE: Delete product image record and actual file
    public function destroy($id)
    {
        $productImage = ProductImage::find($id);

        if (!$productImage) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product image not found!',
                'data'    => null
            ], 404);
        }

        // Delete actual physical file from storage
        if ($productImage->image_url && file_exists(public_path($productImage->image_url))) {
            unlink(public_path($productImage->image_url));
        }

        $productImage->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product image deleted successfully!'
        ], 200);
    }
}
