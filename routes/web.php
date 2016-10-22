<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/register', 'RegistersUsers@showRegistrationForm');

Route::get('/home', 'HomeController@index');

Route::get('/link_error', 'Auth\RegisterController@linkError');

Route::get('/create_link', 'HomeController@createLink');