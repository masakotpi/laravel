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

    //商品
    Route::get('/products','ProductController@index')->name('products_list');
    Route::put('/products/{id}','ProductController@update')->name('product_update');
    Route::post('/products/delete','ProductController@delete')->name('product_delete');

    //商品CSVエクスポート
    Route::post('/products/csv_export','ProductCsvController@export')->name('products_export');
    Route::post('/products/csv_import','ProductCsvController@import')->name('products_import');
});
