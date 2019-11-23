<?php

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "front" middleware group. Now create something great!
|
*/

Route::get('test', ['as' => 'test', 'uses' => 'TestController@test']);

Route::group(['namespace' => 'v1', 'prefix' => 'v1', 'as' => 'v1.'], function () {

    Route::get('login', 'LoginController@login')->name('login');

    Route::group(['middleware' => ['auth']], function () {

    });
});
