<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login','register']]);
        $this->middleware('guest', ['except' => ['username','password']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|email',
            'password' => 'required|string',
        ]);
        
        $credentials = $request->only('username', 'password','remember');
        $admin_token=auth::guard('admin')->attempt($credentials);
        $manager_token=auth::guard('manager')->attempt($credentials);
        if ($admin_token) {
            
            $admin = auth::guard('admin')->user();
            return response()->json([
                    'status' => 'Admin success login',
                    'Admin' => $admin,
                    'authorisation' => [
                        'token' => $admin_token,
                        'type' => 'bearer',
                    ]
            ],200);            
                    
        
        }elseif($manager_token){

            $manager = auth::guard('manager')->user();
            return response()->json([
                    'status' => 'Manager success login',
                    'Manager' => $manager,
                    'authorisation' => [
                        'token' => $manager_token,
                        'type' => 'bearer',
                    ]
            ],200);

        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Wrong credentials , try again !',
            ],401);

        }


    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}