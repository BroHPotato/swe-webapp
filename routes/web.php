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


Auth::routes(['register' => false, 'reset' => false]);

//le Route DEVONO essere ordinate secondo logica di matching "if"

Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');


//routes per gestione profilo
Route::get('/profile', 'ProfileController@index')->name('profile.index');

//routes per gestione user
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/user/{userId}', 'UserController@show')->name('users.show');

//routes per gestione gateways
Route::get('/gateways', 'GatewayController@index')->name('gateway.index');
Route::get('/gateways/{gatewayId}', 'GatewayController@show')->name('gateway.show');

//routes per gestione devices
Route::get('/devices', 'DeviceController@index')->name('devices.index');
Route::get('/device/{deviceId}', 'DeviceController@show')->name('devices.show');




