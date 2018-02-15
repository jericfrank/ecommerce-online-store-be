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
// Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
	// Route::get('logout', 'Auth\SocialAccountController@logout');
	Route::get('logout', 'Auth\LoginController@logout');
});

Route::get('/xxx', function () {
	return [
		'user' => \Auth::user()
	];
});

// passport
Route::post('login', 'Auth\LoginController@login');
Route::post('register', 'Auth\RegisterController@register');