<?php

use Illuminate\Support\Facades\Route;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Request;

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

//メーカー
//一覧
Route::get('/makers','MakerController@index')->name('maker_index');
//新規
Route::post('/makers/new','MakerController@store')->name('maker_new');
//更新
Route::put('/makers/{id}','MakerController@update')->name('maker_update');
//削除
Route::post('/makers/delete','MakerController@delete')->name('maker_delete');


