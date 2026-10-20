<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //get categories
    function show()
    {
        $categories = Category::all();
        return response()->json([
            'status'=>'success',
            'message'=>'Categories retrieved successfully',
            'data'=>$categories
        ],200);
    }
    //get categories by id
    function search($id){
        $category = Category::find($id);
        if($category === null){
            return response()->json([
                'status'=>'error',
                'message'=>'Category not found!!!',
                'data'=>[]
            ],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>'category retrieved successfully',
            'data'=>$category
        ], 200);
    }
    // POST: Create new category
    function store(Request $request){
        $data = $request->validate([
        'name'=>'required|string|max:255',
        'slug'=>'required|string|unique:categories,slug',
        'description'=>'nullable|string',
        'parent_id'=>'nullable|integer|exists:categories,id'
        ]);
        $category = Category::create($data);
        return response()->json([
            'status'=>'success',
            'message'=>'Categories created successfully!!',
            'data'=> $category
            ], 201);
    }
    // PUT: Update category
    function update(Request $request, $id)
    {
        $category = Category::find($id);
        if($category === null){
           return response()->json(
                [
                    'status'=>'error', 
                    'message'=>'Categories not found',
                    'data'=>[]
                ],404
            ); 
        }
        $data = $request->validate([
        'name'=>'sometimes|required|string|max:255',
        'slug'=>'sometimes|required|string|unique:categories,slug,'.$id,
        'description'=>'nullable|string',
        'parent_id'=>'nullable|integer|exists:categories,id'
        ]);
        $category->update($data);
        return response()->json(
            [
                'status'=>'success',
                'message'=>'Categories Updated successfully!!!!', 
                'data'=>$category
            ],200
        );
    }
    // DELETE: Delete category
    function destroy( $id){
        $category = Category::find($id);
        if($category === null){
            return response()->json(
                [
                'status'=>'error',
                'message'=>'Categories not found',
                'data'=>[]
            ],404
            );
        }
        $category->delete();
        return response()->json(
            [
                'status'=>'success',
                'message'=>'Categories Deleted Successfully!!!!'
            ],200
        );
    }
}
