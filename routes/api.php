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



Route::prefix('login')->group(function () {
	Route::post('/', 'Auth\LoginController@login');
	Route::get('{provider}', 'Auth\SocialiteController@redirectToProvider');
	Route::get('{provider}/callback', 'Auth\SocialiteController@handleProviderCallback');
});

Route::post('register', 'Auth\RegisterController@register');

Route::middleware('auth:api')->group(function () {
	Route::get('logout', 'Auth\LoginController@logout');

	Route::prefix('examples')->group(function () {
		Route::resource('companies', 'Examples\CompanyController');
	});
});