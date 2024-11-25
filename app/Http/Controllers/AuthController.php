<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="This is the API documentation for Job-sphere-rda system",
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 */

class AuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login','register']]);
        $this->middleware('guest', ['except' => ['username','password']]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     description="User login. Returns a token if successful.",
     *     operationId="login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"username", "password"},
     *                 @OA\Property(property="username", type="string", format="email"),
     *                 @OA\Property(property="password", type="string", format="password"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="User success login"),
     *             @OA\Property(property="user_data", type="object"),
     *             @OA\Property(property="authorisation", type="object", 
     *                 @OA\Property(property="token", type="string"),
     *                 @OA\Property(property="type", type="string")
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Wrong credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="wrong_Cred", type="string", example="Wrong credentials , try again !")
     *         )
     *     ),
     * )
     */

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|email',
            'password' => 'required|string',
        ]);
        
        $credentials = $request->only('username', 'password','remember');
        $admin_token=auth::guard('admin')->attempt($credentials);
        $user_token=auth::guard('user')->attempt($credentials);
        if ($admin_token) {
            
            $admin = auth::guard('admin')->user();
            return response()->json([
                    'status' => 'Admin success login',
                    'admin_data' => $admin,
                    'authorisation' => [
                        'token' => $admin_token,
                        'type' => 'bearer',
                    ]
            ],200);            
                    
        
        }elseif($user_token){

            $user = auth::guard('user')->user();
            return response()->json([
                    'status' => 'User success login',
                    'user_data' => $user,
                    'authorisation' => [
                        'token' => $user_token,
                        'type' => 'bearer',
                    ]
            ],200);

        }else{
            return response()->json([
                'status' => 'error',
                'wrong_Cred' => 'Wrong credentials , try again !',
            ],401);

        }


    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout",
     *     description="Logs out the user and invalidates the session/token.",
     *     operationId="logout",
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="logout_message", type="string", example="Successfully logged out")
     *         )
     *     ),
     * )
     */

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return response()->json([
            'status' => 'success',
            'logout_message' => 'Successfully logged out',
        ]);
    }

}