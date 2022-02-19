<?php

use Illuminate\Support\Facades\Route;

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


Route::middleware('auth')->group(function () {

//発注
//一覧
Route::get('/orders','OrderController@index')->name('order_index');
//新規
Route::post('/orders/new','OrderController@store')->name('order_new');
//更新
Route::put('/orders/{id}','OrderController@update')->name('order_update');
//削除
Route::post('/orders/delete','OrderController@delete')->name('order_delete');

});
