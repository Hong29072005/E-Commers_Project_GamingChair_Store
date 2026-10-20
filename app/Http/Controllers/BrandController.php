<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // GET: Get all brands
    function show()
    {
        $brands = Brand::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Brand retrieved successfully',
            'data' => $brands
        ], 200);
    }
    // GET: Search brand by ID
    function search($id){
        $brand = Brand::find($id);
        if($brand === null){
            return response()->json([
                'status'=>'error',
                'message'=>'brand not found!!!',
                'data'=>[]
            ],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>'Brand retrieved successfully',
            'data'=>$brand
        ], 200);
    }
    // POST: Create a new brand
    function store(Request $request)
    {
        $data = $request->validate([
        'name'        => 'required|string|max:255',
        'logo_url'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'nullable|string',
        ]);
        if ($request->hasFile('logo_url')) {
            $logo_file = $request->file('logo_url');
            $logo_name = time() . '_' . uniqid() . '.' . $logo_file->getClientOriginalExtension();

            // Upload to public/brands/upload_logo
            $logo_file->move(public_path('brands/upload_logo'), $logo_name);

            $data['logo_url'] = 'brands/upload_logo/' . $logo_name;
        }
        $brand = Brand::create($data);
        return response()->json(
            [
                'status'=>'success',
                'message'=>'brand created successfully!!!!',
                'data'=>$brand
            ],201
        );
    }
    // PUT / POST (_method=PUT): Update brand
    function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if($brand === null){
            return response()->json(
                [
                    'status'=>'error', 
                    'message'=>'Brand not found',
                    'data'=>[]
                ],404
            );
        }
        $data = $request->validate([
        'name'        => 'sometimes|required|string|max:255',
        'logo_url'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'nullable|string',
        ]);
        if ($request->hasFile('logo_url')) {
            // Delete old picture if exists
            if ($brand->logo_url && file_exists(public_path($brand->logo_url))) {
                unlink(public_path($brand->logo_url));
            }

            $logo_file = $request->file('logo_url');
            $logo_name = time() . '_' . uniqid() . '.' . $logo_file->getClientOriginalExtension();

            // Upload to public/brands/upload_logo
            $logo_file->move(public_path('brands/upload_logo'), $logo_name);

            $data['logo_url'] = 'brands/upload_logo/' . $logo_name;
        } else {
            // ការពារកុំឱ្យ Overwrite logo_url ចាស់ ប្រសិនបើគ្មាន File ថ្មី Upload មក
            unset($data['logo_url']);
        }
        $brand->update($data);
        return response()->json(
            [
                'status'=>'success',
                'message'=>'Brand Updated successfully!!!!', 
                'data'=>$brand
            ],200
        );
    }
    // DELETE: Delete brand
    function destroy($id){
        $brand = Brand::find($id);
        if($brand === null){
            return response()->json(
                [
                'status'=>'error',
                'message'=>'Brand not found',
                'data'=>[]
            ],404
            );
        }
        // Delete old picture if exists
        if ($brand->logo_url && file_exists(public_path($brand->logo_url))) {
            unlink(public_path($brand->logo_url));
        }
        $brand->delete();
        return response()->json(
            [
                'status'=>'success',
                'message'=>'brand Deleted Successfully!!!!'
            ],200
        );
    }
}
