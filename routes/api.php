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

        Route::group(['prefix' => 'system', 'as' => 'system.'], function () {
            Route::get('server', 'SystemController@server')->name('server'); // 서버 상태 확인.
            Route::get('notice', 'SystemController@notice')->name('notice'); // 서버 공지 사항 확인.
            Route::get('sitedata', 'SystemController@sitedata')->name('sitedata'); // 기본 싸이트 데이터.
        });

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('{user_uuid}/profile', 'UserController@profile')->name('profile'); // 사용자 프로필 데이터 전달.
        });


		Route::group(['middleware' => 'auth:api'], function () {
            Route::post('token/refresh', 'PassportController@token_refresh')->name('token.refresh'); // 토큰 리프레쉬 요청 (테스트).

            Route::post('post', 'PostController@create')->name('post.create'); // 글등록.

            Route::group(['prefix' => 'my', 'as' => 'my.'], function () {
                Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
                    Route::get('', 'ProfileController@me')->name('get'); // 사용자 프로필 데이터 전달.
                    Route::put('', 'ProfileController@update')->name('update'); // 사용자 프로필 정보 업데이트.
                    Route::put('image', 'ProfileController@image_update')->name('image.update'); // 사용자 프로필 업데이트.
                });
			});
		});
	});
});
