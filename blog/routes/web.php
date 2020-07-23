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

Route::get('/login','Backend\IndexController@getLogin')->name('login');
Route::post('/login','Backend\IndexController@postLogin');
Route::get('/logout','Backend\IndexController@getLogout');
Route::get('/error','Backend\IndexController@getError')->name('truycap');
Route::group(['middleware'=>'checkuser'],function(){

	Route::group(['middleware'=>'checkmanager'],function(){
		Route::get('/','Backend\IndexController@index')->name('hokhau');
		Route::get('/them-ho-khau.html','Backend\IndexController@getAddHokhau');
		Route::post('/them-ho-khau.html','Backend\IndexController@postAddHokhau');
		Route::get('/sua-ho-khau/{id}','Backend\IndexController@getHokhau');
		Route::post('/sua-ho-khau/{id}','Backend\IndexController@setHokhau');
		Route::get('/xoa-ho-khau/{id}','Backend\IndexController@deleteHokhau');


		// quản lý nhân khẩu admin
		Route::get('/quan-ly-nhan-khau.html','Backend\nhankhauController@getAll');
	});
	

// Quản lý nhân khẩu
Route::get('/nhan-khau/export-{id}','Backend\nhankhauController@export2')->name('export');
Route::get('/nhan-khau/{id}','Backend\nhankhauController@index')->name('nhankhau');

Route::get('/nhan-khau/them-nhan-khau/{id}','Backend\nhankhauController@getAdd')->name('themnhankhau')->middleware('checkmanager');
Route::post('/nhan-khau/them-nhan-khau/{id}','Backend\nhankhauController@postAdd')->middleware('checkmanager');
Route::get('/nhan-khau/xoa-nhan-khau/{id}-{id_hk}','Backend\nhankhauController@delete')->middleware('checkmanager');
Route::get('/nhan-khau/sua-nhan-khau/{id}-{id_hk}','Backend\nhankhauController@getEdit')->middleware('checkmanager');
Route::post('/nhan-khau/sua-nhan-khau/{id}-{id_hk}','Backend\nhankhauController@postEdit')->middleware('checkmanager');

Route::get('/danh-sach-nhan-khau/{id}','Backend\nhankhauController@ajaxIndex')->middleware('checkmanager');
Route::get('/ho-khau/export','Backend\IndexController@export2')->middleware('checkmanager');

});