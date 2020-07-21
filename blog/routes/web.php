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

Route::get('/','Backend\IndexController@index')->name('hokhau');

Route::get('/them-ho-khau.html','Backend\IndexController@getAddHokhau');
Route::post('/them-ho-khau.html','Backend\IndexController@postAddHokhau');


Route::get('/sua-ho-khau/{id}','Backend\IndexController@getHokhau');
Route::post('/sua-ho-khau/{id}','Backend\IndexController@setHokhau');
Route::get('/xoa-ho-khau/{id}','Backend\IndexController@deleteHokhau');