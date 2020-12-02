<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'UsersController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// get←新規登録フォームを表示させる
// post←ユーザ登録したい情報を送信する

// Route::get('アドレス(〇〇/{パラメータ})', '関数orコントローラ名@アクション名')->name('ルーティングに名前をつける');
// Viewファイルでアクション名は使われる・アクション名は自分で決めることが可能

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::resource('users', 'UsersController', ['only' => ['show']]);

Route::group(['middleware' => 'auth'], function () {
    // ログイン済のユーザしか名前変更のrenameにアクセスできない様するため
    // →次はController
    Route::put('users', 'UsersController@rename')->name('rename');
    Route::resource('movies', 'MoviesController', ['only' => ['create', 'store', 'destroy']]);
});

Route::resource('users', 'UsersController', ['only' => ['show']]);

Route::group(['prefix' => 'users/{id}'], function () {
    Route::get('followings', 'UsersController@followings')->name('followings');
    Route::get('followers', 'UsersController@followers')->name('followers');
    });

Route::group(['middleware' => 'auth'], function () {
    Route::put('users', 'UsersController@rename')->name('rename');
    
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('unfollow');
    });
    
    Route::resource('movies', 'MoviesController', ['only' => ['create', 'store', 'destroy']]);
});

Route::resource('rest','RestappController', ['only' => ['index', 'show', 'create', 'store', 'destroy']]);