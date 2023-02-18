<?php

namespace App\Http\Controllers\ForgotPSWD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;
use App\Mail\SendLinkEMail;
use Illuminate\Mail\Mailable;
use Carbon\Carbon; 
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function ForgotPassword(Request $request){

        $admin=Admin::all();
        foreach ($admin as $value) {
            $admin_email=$value->email;
        }

        $manager_email=DB::Table('users')->select('email')->where('email',$request->email)->get();


        if ($admin_email === $request->email) {
            
            $request->validate([
              'email' => 'required|email|exists:admins',
            ]);
            
            $AdminData=DB::Table('password_resets')->select('email')->where('email',$request->email)->get();

            $countAdmin=collect($AdminData)->count();
            if ($countAdmin == 1) {
                DB::table('password_resets')->where(['email'=> $request->email])->delete();
            }

            $token = Str::random(64);
      
            DB::table('password_resets')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
      
            $tokenData=DB::Table('password_resets')->select('token')->where('email',$request->email)->get();

            // Send email to user
            Mail::to($request->email)->send(new SendLinkEMail(['token' => $token]));
            
            // Mail::send('email.forgotPassword', ['token' => $token], function($message) use($request){
            //     $message->to($request->email);
            //     $message->subject('Reset Password');
            // },200);
            
            return response()->json([
                'message' => 'We e-mailed you , your password reset link on your email !',
            ],200);

        }else{

            return response()->json([
                'message' => 'This email '.$request->email.' not found in our records !',
            ],401);

        }

            
    }

    public function showResetPasswordForm($token){
        return response()->json([
            'token' => $token,
        ]);
    }
}
