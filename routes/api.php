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

Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');

Route::middleware('auth:api')->group(function () {
	Route::get('logout', 'Auth\LoginController@logout');

	Route::prefix('examples')->group(function () {
		Route::resource('books', 'Examples\BookController');
	});
});

Route::post('login', 'Auth\LoginController@login');
Route::post('register', 'Auth\RegisterController@register');