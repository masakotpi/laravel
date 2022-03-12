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
//入荷予定更新
Route::post('/orders/shippings','OrderController@updateShippings')->name('order_update_shippings');
//PDF発注書発行
Route::post('/orders/issue_po','OrderController@issuePo')->name('issue_po');
//削除
Route::post('/orders/delete','OrderController@delete')->name('order_delete');


});
