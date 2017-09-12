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
    return view('index_w');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/buy/{slug}', 'BuyController@buy');
Route::post('/buy/tz/{slug}', 'BuyController@tz');

Route::post('/admin/api/result/{slug}', 'AdminController@resultUpdate');

//北京单场
Route::get('/dc/{type}', 'DcController@index');

//竞彩足球
Route::get('/zq/{type}', 'ZqController@index');

//竞彩篮球
Route::get('/lq/{type}', 'LqController@index');

//用户相关
Route::get('/user/{type}', 'UserController@index');

//合买大厅
Route::get('/hm/{type}', 'HmController@index');

//购物车
Route::get('/cart/{type}', 'CartController@index');

//支付
Route::get('/pay/', 'PayController@index');