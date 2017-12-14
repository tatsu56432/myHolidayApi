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

//Route::pattern('apiVersion2', 'v2');
Route::group(['namespace' => 'Api\V2'], function() {
    Route::resource('holidays', 'HolidayController', ['except' => ['create', 'edit', 'show']]);
    Route::get('/v2/holidays/{id}', 'HolidayController@show');
});

//Route::pattern('apiVersion1', 'v[12]');
//Route::pattern('id', '[0-9]+');

Route::group(['namespace' => 'Api\V1'], function () {
    Route::resource('holidays', 'HolidayController', ['except' => ['create', 'edit', 'show']]);
    Route::get('/v1/holidays/{id}', 'HolidayController@show');
});

//Route::resource('holidays', 'HolidayController', ['except' => ['create', 'edit', 'show']]);
//Route::get('/holidays/{id}', 'HolidayController@show');
//Route::group(['namespace' => 'Api\V1'], function() {
//    Route::get('/holidays/{id?}', 'HolidayController@show');
//});
//Route::resource('/holidays', 'HolidayController', ['except' => ['create', 'edit' ,'show']]);
//Route::get('/holidays/{id}', 'HolidayController@show');
//Route::resource('/items', 'ItemController', ['except' => ['create', 'edit']]);