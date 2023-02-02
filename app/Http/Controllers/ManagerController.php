<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

}
