<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/users', 'UserController@index');

    Route::get('/vehicles', 'VehicleController@index');
    Route::post('/vehicles', 'VehicleController@store');
    Route::get('/vehicles/{id}', 'VehicleController@show');
    Route::put('/vehicles/{id}', 'VehicleController@update');
    Route::delete('/vehicles/{id}', 'VehicleController@destroy');
});

Route::post('/login', 'UserController@login');
Route::post('/logout', 'UserController@logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
