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

//le Route DEVONO essere ordinate secondo logica di matching "if"

Route::get('/user/{user}', 'UserController@index')->name('profile.show');
Route::get('/user/{user}/devices', 'DevicesController@index')->name('device.index'); //todo
Route::get('/user/{user}/devices/{device}', 'DevicesController@show')->name('device.show'); //todo
