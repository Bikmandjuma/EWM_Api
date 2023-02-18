<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\customer;

class ManagerController extends Controller
{
    public function ViewMyInfo(){
        $info=auth::guard()->user();
        return response()->json([
            'status' => 'success',
            'message' => 'My information',
            'user' => $info,
        ],200);
    }

    public function CreateCustomer(Request $request){
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|min:10|unique:customers',
            'image' => 'required|string',
            'province' => 'required|string',
            'district' => 'required|string',
            'sector' => 'required|string',
            'cell' => 'required|string',
            'village' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $customer = customer::create([
            'firstname'=> $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $request->image,
            'province' => $request->province,
            'district' => $request->district,
            'sector' => $request->sector,
            'cell' => $request->cell,
            'village' => $request->village,
            'password' => Hash::make($request->password),
        ]);  

        return response()->json([
            'status' => 'success',
            'message' => 'Manager create customer ,  successfully',
            'Customer' => $customer,
        ],200);          
    }

    public function ViewAllCustomer(){
        $customers=customer::all();
        return response()->json([
            'status' => 'success',
            'message' => 'All customers info',
            'Customer' => $customers,
        ],200);
    }

    public function ViewSingleCustomer($id){
        $customer=customer::find($id);
        
        if ($customer) {
        	return response()->json([
	            'status' => 'success',
	            'message' => 'Customer info',
	            'Customer' => $customer,
	        ],200);

        }else{

        	return response()->json([
		        'status' => 'error',
		        'message' => 'Invalid customer id ,'.$id.'',
		    ],200);

        }
        
    }


}
