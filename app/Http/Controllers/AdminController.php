<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\admin;
use App\Models\customer;

class AdminController extends Controller
{
    
    public function AdminCreateManager(Request $request){
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:10|unique:users',
            'image' => 'required|string',
            'sitename' => 'required|string',
            'username'  => 'required|string',
            'password' => 'required|string|min:8',
 
        ]);

        $user = User::create([
            'firstname'=> $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $request->image,
            'sitename' => $request->sitename,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'Admin create manager ,  successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ],200);
    }

    public function ViewAllManagers(){
        $managers=User::all();
        return response()->json([
            'status' => 'success',
            'message' => 'All managers info',
            'user' => $managers,
        ],200);
    }

    public function AddCustomer(Request $request){
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|min:10|unique:customers',
            'province' => 'required|string',
            'district' => 'required|string',
            'sector' => 'required|string',
            'cell' => 'required|string',
            'village' => 'required|string',
        ]);

        $fname=substr($request->firstname,0,1);
        $lname=substr($request->lastname,0,1);
        $xo=rand(0,9);
        $xy=substr(date('y'),0,1);
        $xx=substr(date('y'),1,1);
        $xd=substr(date('d'),0,1);
        $xi=date('i');
        $xs=date('s');

        $swm_sn=$fname.$xy.$xo.$xx.$lname.$xd.$xi.$xs;
        $customer = customer::create([
            'firstname'=> $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'province' => $request->province,
            'district' => $request->district,
            'sector' => $request->sector,
            'cell' => $request->cell,
            'village' => $request->village,
            'swm_sn' => $swm_sn,
            'password' => Hash::make($request->phone),
        ]);     

        return response()->json([
            'status' => 'success',
            'message' => 'Admin create customer ,  successfully',
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

    public function Update_My_Info(Request $request){
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:10|unique:users',
            'image' => 'required|string',
            'username'  => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $Admin_info=DB::table('admin')->update([
            'firstname' =>$request->fname,
            'lastname' =>$request->lname,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'image' =>$request->image,
            'username' =>$request->username,
            'password' =>$request->password,
        ]);

        if ($Admin_info == true) {
            
            return responce()->json([
                'status' => 'success',
                'message' => 'Data updated successfully !',
            ],200);

        }else{

            return responce()->json([
                'status' => 'error',
                'message' => 'Error to update data !',
            ],401);

        }

    }


}