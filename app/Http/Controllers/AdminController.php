<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
}
