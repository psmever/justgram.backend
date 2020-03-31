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

        Route::group(['prefix' => 'system', 'as' => 'system.'], function () {
            Route::get('server', 'SystemController@server')->name('server'); // 서버 상태 확인.
            Route::get('notice', 'SystemController@notice')->name('notice'); // 서버 공지 사항 확인.
            Route::get('sitedata', 'SystemController@sitedata')->name('sitedata'); // 기본 싸이트 데이터.
        });

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('{user_uuid}/profile', 'UserController@profile')->name('profile'); // 사용자 프로필 데이터 전달.

            Route::group(['middleware' => 'auth:api'], function () {
                Route::get('{user_uuid}/following', 'UserController@following_index')->name('following.index'); // 사용자 following 리스트.
                Route::get('{user_uuid}/followers', 'UserController@followers_index')->name('followers.index'); // 사용자 followers 리스트.
                Route::post('follow', 'UserController@follow_create')->name('follow.create'); // 사용자 팔로우 추가.
                Route::delete('follow', 'UserController@follow_delete')->name('follow.delete'); // 사용자 팔로오 삭제.
            });

        });

        Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
            Route::get('', 'PostController@index')->name('index');
        });


		Route::group(['middleware' => 'auth:api'], function () {
            Route::post('token/refresh', 'PassportController@token_refresh')->name('token.refresh'); // 토큰 리프레쉬 요청 (테스트).

            Route::post('post', 'PostController@create')->name('post.create'); // 글등록.
            Route::post('post/comment', 'PostController@comment_create')->name('post.comment.create'); // 포스트 댓글 등록.

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
