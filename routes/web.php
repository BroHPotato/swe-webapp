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

Route::redirect('/', '/dashboard');

Auth::routes(['register' => false, 'reset' => false]);

//le Route DEVONO essere ordinate secondo logica di matching "if"

Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('/login/tfa', 'Auth\LoginController@showTfaForm')->name('tfaLogin');

//routes per gestione profilo
//Route::get('/settings', 'SettingsController@index')->name('settings.index');
Route::get('/settings/edit', 'SettingsController@edit')->name('settings.edit');
Route::put('/settings', 'SettingsController@update')->name('settings.update');

//routes per gestione user
Route::get('/users', 'UserController@index')->middleware('can:isAdmin')->name('users.index'); // limita users agli admin
Route::get('/user/{userId}/edit', 'UserController@edit')->name('users.edit');
Route::get('/user/{userId}', 'UserController@show')->name('users.show');
Route::get('/user/create', 'UserController@create')->name('users.create');
Route::post('/user', 'UserController@store');
Route::put('/user/{userId}', 'UserController@update');
Route::delete('/user/{userId}', 'UserController@delete');

//routes per gestione gateways
Route::get('/gateways', 'GatewayController@index')->name('gateway.index');
Route::get('/gateway/{gatewayId}', 'GatewayController@show')->name('gateway.show');

//routes per gestione devices
Route::get('/devices', 'DeviceController@index')->name('devices.index');
Route::get('/device/{deviceId}', 'DeviceController@show')->name('devices.show');

//routes per gestione devices
Route::get('/device/{deviceId}/sensors', 'SensorController@index')->name('sensors.index');
Route::get('/device/{deviceId}/sensor/{sensorId}', 'SensorController@show')->name('sensors.show');


//routes per gestione entity
Route::get('/entities', 'EntityController@index')->name('entities.index');
Route::get('/entity/{entityId}', 'EntityController@show')->name('entities.show');
