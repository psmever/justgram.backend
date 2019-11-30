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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//Auth::routes(['verify' => true]);
Route::group(['namespace' => 'v1', 'prefix' => 'v1', 'as' => 'v1.'], function () {

	Route::post('register', 'PassportController@register')->name('register');
	Route::post('login', 'PassportController@login')->name('login');
	Route::post('gettoken', 'PassportController@gettoken')->name('getoken'); // 토큰 요청 (테스트)
//	Route::post('login', 'PassportController@login')->name('login');

	Route::group([
		'middleware' => [
			'auth:api',
			'auth:api',
			'apiafter'
		]

	], function () {
		Route::get('me', 'UserController@me');




	});

});