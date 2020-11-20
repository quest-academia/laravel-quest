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

Route::get('/', function () {
    return view('welcome');
});

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// get←新規登録フォームを表示させる
// post←ユーザ登録したい情報を送信する

// Route::get('アドレス(〇〇/{パラメータ})', '関数orコントローラ名@アクション名')->name('ルーティングに名前をつける');
// Viewファイルでアクション名は使われる・アクション名は自分で決めることが可能