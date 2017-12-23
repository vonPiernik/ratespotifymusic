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

// Route::view('/', 'app');

Route::get('/', 'SpotifyAuthController@home');

Route::get('session', function(){
	return session()->all();
});

Route::get('callback', 'SpotifyAuthController@callback');

Route::get('auth', 'SpotifyAuthController@auth');