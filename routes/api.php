<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'JustGram', 'prefix' => 'justgram', 'as' => 'justgram.'], function () {
	Route::group(['namespace' => 'v1', 'prefix' => 'v1', 'as' => 'v1.'], function () {

		Route::post('register', 'PassportController@register')->name('register');
		Route::post('login', 'PassportController@login')->name('login');
		Route::post('gettoken', 'PassportController@gettoken')->name('getoken'); // 토큰 요청 (테스트)

        Route::post('login', 'PassportController@login')->name('login');

        Route::group(['prefix' => 'system', 'as' => 'system.'], function () {
            Route::get('server', 'SystemController@server')->name('server'); // 서버 상태 확인.
            Route::get('notice', 'SystemController@notice')->name('notice'); // 서버 공지 사항 확인.
            Route::get('sitedata', 'SystemController@sitedata')->name('sitedata'); // 기본 싸이트 데이터.
        });

		Route::group(['middleware' => 'auth:api'], function () {
			Route::post('token/refresh', 'PassportController@token_refresh')->name('token.refresh'); // 토큰 리프레쉬 요청 (테스트).
			Route::get('me', 'UserController@test')->name('me');


			Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
                Route::get('profile/me', 'UserController@profile_me')->name('profile.me'); // 사용자 프로필 업데이트
                Route::post('profile/update', 'UserController@profile_update')->name('profile.update'); // 사용자 프로필 업데이트
                Route::post('profile/image/update', 'UserController@profile_image_update')->name('profile.image.update'); // 사용자 프로필 업데이트
			});
		});
	});
});
