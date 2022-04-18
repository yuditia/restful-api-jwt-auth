<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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





Route::group(['middleware' => 'api'], function ($router) {

    Route::group(['prefix'=>'auth'], function(){
        Route::post('login', [AuthController::class,'login'])->name('login');
        Route::post('logout', [AuthController::class,'logout']);
        Route::post('refresh', [AuthController::class,'refresh']);
        Route::post('me', [AuthController::class,'me']);
    });

    Route::group(['prefix'=>'v1'],function(){
        Route::resource('employee',EmployeeController::class);
        Route::resource('users',UserController::class);
    });

});
