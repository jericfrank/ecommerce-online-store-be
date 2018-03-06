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
	Route::get('{provider}/provider', 'Auth\SocialiteController@redirectToProvider');
	Route::get('{provider}/callback', 'Auth\SocialiteController@handleProviderCallback');
	Route::get('{provider}/auth', 'Auth\SocialiteController@handleProviderAuth');
});

Route::post('register', 'Auth\RegisterController@register');

Route::get('logout', 'Auth\LoginController@logout');

Route::prefix('examples')->group(function () {
	Route::resource('companies', 'Examples\CompanyController');
});

Route::prefix('products')->group(function () {
	Route::get('items', 'Products\ItemController@index');
	Route::post('items', 'Products\ItemController@store');
	Route::get('categories', 'Products\CategoryController@index');
	Route::post('categories', 'Products\CategoryController@store');
});