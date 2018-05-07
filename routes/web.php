<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'IndexController@index');

//Route::get('auth/login', 'Auth\AuthController@getLogin');
//Route::post('auth/login', 'Auth\AuthController@postLogin');
//Route::get('auth/logout', 'Auth\AuthController@getLogout');
//
//// Registration routes...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('welcome/{name?}', function($name = "ゲスト") {
    Mail::send('email.welcome', ['name' => $name], function($message) {
        $message->to('tatsu56432@gmail.com')->subject('Welcome');
    });

    return "Welcome メッセージを $name に送りました";
});

Route::get('/mail','HomeController@send');

Route::get('/hello/{message}', function($message)
{
    return 'Hello World' .'  '.  $message;
})->where('message', '[A-Za-z]+');
