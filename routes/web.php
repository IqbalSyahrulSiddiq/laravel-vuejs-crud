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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/siswa', 'SiswaController@index')->name('siswa.index');
Route::get('/siswa/list', 'SiswaController@getData')->name('siswa.getData');
Route::post('/siswa/post', 'SiswaController@storeSiswa')->name('siswa.storeSiswa');
Route::get('/siswa/detail/{id}', 'SiswaController@detailSiswa')->name('siswa.detailSiswa');
Route::get('/siswa/delete/{id}', 'SiswaController@deleteSiswa')->name('siswa.deleteSiswa');