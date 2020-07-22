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

// Quản lý nhân khẩu
Route::get('/nhan-khau/export-{id}','Backend\nhankhauController@export2')->name('export');
Route::get('/nhan-khau/{id}','Backend\nhankhauController@index')->name('nhankhau');

Route::get('/nhan-khau/them-nhan-khau/{id}','Backend\nhankhauController@getAdd')->name('themnhankhau');
Route::post('/nhan-khau/them-nhan-khau/{id}','Backend\nhankhauController@postAdd');
Route::get('/nhan-khau/xoa-nhan-khau/{id}-{id_hk}','Backend\nhankhauController@delete');
Route::get('/nhan-khau/sua-nhan-khau/{id}-{id_hk}','Backend\nhankhauController@getEdit');
Route::post('/nhan-khau/sua-nhan-khau/{id}-{id_hk}','Backend\nhankhauController@postEdit');

Route::get('/danh-sach-nhan-khau/{id}','Backend\nhankhauController@ajaxIndex');
Route::get('/ho-khau/export','Backend\IndexController@export2');
