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

Route::get('wechat',function(){
  $wechat = session('wechat.oauth_user.default');
  dd($wechat);
})->Middleware('WeChat');

Route::get('wxcode','WeChatController@wxcode');
Route::get('wxtoken','WeChatController@wxtoken')->name('wxtoken');

Route::any('WeChat','WeChatController@auth')->Middleware('WeChat')->name('Login.WeChat');
