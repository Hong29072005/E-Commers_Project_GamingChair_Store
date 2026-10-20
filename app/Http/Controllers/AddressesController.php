<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    // GET: Get all addresses
    function show(){
        $addresses = Addresses::with('customer')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Addresses retrieved successfully',
            'data' => $addresses
        ], 200);
    }
    // GET: Get address by ID
    function search($id){
        $address = Addresses::with('customer')->find($id);
        if($address === null){
            return response()->json([
                'status'=>'error',
                'message'=>'Addresses not found!!!',
                'data'=>[]
            ],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>'Address retrieved successfully',
            'data'=>$address
        ], 200);
    }
    // POST: Create new address
    function store(Request $request){
        $data = $request->validate([
        'customer_id'=> 'required|integer|exists:customers,id',
        'label'=> 'nullable|string',
        'full_name'=> 'required|string',
        'phone'=> 'nullable|string',
        'address_line1'=> 'required|string',
        'address_line2'=> 'nullable|string',
        'city'=> 'required|string',
        'state'=> 'nullable|string',
        'postal_code'=> 'required|string',
        'country'=> 'nullable|string',
        'is_default'=> 'nullable|boolean'
        ]);
        // ប្រសិនបើ user ជ្រើសរើសអាសយដ្ឋាននេះជា default ត្រូវដក default ចេញពី address ចាស់ៗ
        if (!empty($data['is_default']) && $data['is_default'] == true) {
            Addresses::where('customer_id', $data['customer_id'])
                ->update(['is_default' => false]);
        }
        $address = Addresses::create($data);
        return response()->json([
            'status'=>'success',
            'message'=>'Address created successfully!!!',
            'data'=>$address
        ],201);
    }
    // PUT: Update address
    function update(Request $request, $id){
        $address = Addresses::find($id);
        if($address === null){
            return response()->json([
                'status'=>'error',
                'message'=>'Address not found!!!',
                'data'=>[]
            ],404);
        }
        $data = $request->validate([
        'customer_id'   => 'required|integer|exists:customers,id',
        'label'         => 'nullable|string',
        'full_name'     => 'required|string',
        'phone'         => 'nullable|string',
        'address_line1' => 'required|string',
        'address_line2' => 'nullable|string',
        'city'          => 'required|string',
        'state'         => 'nullable|string',
        'postal_code'   => 'required|string',
        'country'       => 'nullable|string',
        'is_default'    => 'nullable|boolean'
        ]);
        // ប្រសិនបើកែប្រែឱ្យទៅជា default address ត្រូវដក default ចេញពី address ដទៃទៀត
        if (!empty($data['is_default']) && $data['is_default'] == true) {
            Addresses::where('customer_id', $data['customer_id'])
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }
        $address->update($data);
        return response()->json([
            'status'=>'success',
            'message'=>'Address Updated successfully!!!!', 
            'data'=>$address
        ],200);
    }
    // DELETE: Delete address
    function destroy($id){
        $address = Addresses::find($id);
        if($address === null){
        return response()->json([
            'status'=>'error',
            'message'=>'Address not found!!!',
            'data'=>[]
            ],404);
        }
        $address->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'Address Deleted Successfully!!!!'
        ],200);
    }
}
