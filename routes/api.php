<?php

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::group(["namespace"=>"App\Http\Controllers\Api"],function() {
    Route::get('/','ServiceController@index');

});
Route::get('mo/checkUser_app',[App\Http\Controllers\Api\MobileController::class, 'checkUser_app']);

Route::get('mo/gleave_register',[App\Http\Controllers\Api\MobileController::class, 'gleave_register']);

// Route::post('checkUser','App\Http\Controllers\Api\MobileController@store');
Route::get('demo',function(Request $request){
return $request->json('demo');
});

// http://27.254.191.157/gtw/api/mo/checkUser_app
// http://27.254.191.157/gtw/api/gleave_register
