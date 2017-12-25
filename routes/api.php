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
Route::post('ratings', 'RatingsController@store');

Route::get('ratings/{item_id}', 'RatingsController@average');

Route::get('ratings/{user_id}/{item_id}', 'RatingsController@my');

Route::get('spotify/featuredAlbums', 'SpotifyController@featuredAlbums');

Route::get('spotify/search', 'SpotifyController@search');