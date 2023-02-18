<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ForgotPSWD\ForgotPasswordController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

//Admin
Route::group(['prefix' => 'admin','middleware' => 'adminauth'], function () {
	Route::controller(AdminController::class)->group(function(){
		Route::post('CreateManager','AdminCreateManager');
	    Route::get('view/managers','ViewAllManagers');
	    Route::post('add/customer','AddCustomer');	
	    Route::get('View/all/customer','ViewAllCustomer');	
	    Route::post('View/Single/Customer/{id}','ViewSingleCustomer');
	    Route::post('Update/MyInfo','Update_My_Info');
	}); 
});

//Manager
Route::group(['prefix' => 'manager','middleware' => 'managerauth'], function () {
	Route::controller(ManagerController::class)->group(function(){
		Route::get('view/myinfo','ViewMyInfo');
	    Route::post('create/customer','CreateCustomer');
	    Route::get('check/all/customer','ViewAllCustomer');	
	    Route::post('check/Single/Customer/{id}','ViewSingleCustomer');
	});
});

//forgot password
Route::controller(ForgotPasswordController::class)->group(function(){
	Route::get('reset-password/{token}','showResetPasswordForm')->name('reset.password.get');
	Route::post('forgot/password','ForgotPassword');
});
