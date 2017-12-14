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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::resource('/holidays', 'HolidayController', ['except' => ['create', 'edit' ,'show']]);

Route::get('/holidays/{id}', 'HolidayController@show');


//Route::resource('/holidays/2017', 'HolidayController', ['except' => ['create', 'edit']]);
//Route::resource('/items', 'ItemController', ['except' => ['create', 'edit']]);