<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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
    Route::post('CreateManager',[AdminController::class,'AdminCreateManager']);
    Route::get('view/managers',[AdminController::class,'ViewAllManagers']);
});

//Manager
Route::group(['prefix' => 'manager','middleware' => 'managerauth'], function () {
    Route::get('view/myinfo',[ManagerController::class,'ViewMyInfo']);
});
