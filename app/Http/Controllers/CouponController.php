<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // Get all coupon (ទាញយក ប័ណ្ណបញ្ចុះតម្លៃ ទាំងអស់) 
    public function show()
    {
        $coupons = Coupon::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Coupons items retrieved successfully',
            'data' => $coupons
        ], 200);
    }
    // Get coupon by ID
    public function search($id)
    {
        $coupon = Coupon::find($id);

        if ($coupon === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Coupon not found!!!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Coupon retrieved successfully',
            'data' => $coupon
        ], 200);
    }
    //Post (Create new coupon)
    public function store(Request $request)
    {
        $data = $request->validate([
        'code'=> 'required|string|max:50|unique:coupons,code',
        'discount_type'=>'required|string|in:percentage,fixed',
        'discount_value'=>'required|numeric|min:0',
        'min_order_amount'=>'nullable|numeric|min:0',
        'valid_from'=>'nullable|date',
        'valid_until'=>'nullable|date|after_or_equal:valid_from',
        'usage_limit'=>'nullable|integer|min:1',
        'used_count' => 'nullable|integer|min:0',
        'is_active'=> 'nullable|boolean',
        ]);
        // កំណត់ used_count ត្រឹម 0 ដំបូង
        $data['used_count'] = 0;

        $coupon = Coupon::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Coupon created successfully!!!',
            'data' => $coupon
        ], 201);
    }
    //Put (Update coupon)
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        if($coupon === null){
            return response()->json([
                'status'=>'error',
                'message'=>'Coupon not found!!',
                'data'=>[]
            ], 404);
        }
        $data = $request->validate([
        'code'=> 'required|string|max:50|unique:coupons,code,' . $id,
        'discount_type'=>'required|string|in:percentage,fixed',
        'discount_value'=>'required|numeric|min:0',
        'min_order_amount'=>'nullable|numeric|min:0',
        'valid_from'=>'nullable|date',
        'valid_until'=>'nullable|date|after_or_equal:valid_from',
        'usage_limit'=>'nullable|integer|min:1',
        'used_count' => 'nullable|integer|min:0',
        'is_active'=> 'nullable|boolean',
        ]);
        $coupon->update($data);
        return response()->json([
            'status'=>'success',
            'message'=>'Coupon updated successfully!!!',
            'data'=>$coupon
        ],200);
    }
    //delete (Remove coupon)
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        if($coupon === null){
            return response()->json([
                'status'=>'error',
                'message'=>'Coupon not found!!',
                'data'=>[]
            ], 404);
        }
        $coupon->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Coupon deleted successfully!!'
        ],200);
    }
}
