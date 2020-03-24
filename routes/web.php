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
Route::get('/settings/edit', 'SettingsController@edit')->name('settings.edit');
Route::put('/settings', 'SettingsController@update')->name('settings.update');

//routes per gestione user
Route::get('/users', 'UserController@index')/*->middleware('can:isAdmin')*/->name('users.index'); // limita users agli admin
Route::get('/users/create', 'UserController@create')->name('users.create');//TODO
Route::post('/users', 'UserController@store')->name('users.store');
Route::get('/users/{userId}', 'UserController@show')->name('users.show');//TODO
Route::get('/users/{userId}/edit', 'UserController@edit')->name('users.edit');//TODO
Route::put('/users/{userId}', 'UserController@update')->name('users.update');
Route::put('/users/{userId}', 'UserController@restore')->name('users.restore');
Route::delete('/users/{userId}', 'UserController@destroy')->name('users.destroy');

//routes per gestione gateways
Route::get('/gateways', 'GatewayController@index')->name('gateway.index');//TODO
Route::get('/gateway/{gatewayId}', 'GatewayController@show')->name('gateway.show');//TODO

//routes per gestione devices
Route::get('/devices', 'DeviceController@index')->name('devices.index');
Route::get('/device/{deviceId}', 'DeviceController@show')->name('devices.show');//TODO

//routes per gestione devices
Route::get('/device/{deviceId}/sensors', 'SensorController@index')->name('sensors.index');//TODO
Route::get('/device/{deviceId}/sensor/{sensorId}', 'SensorController@show')->name('sensors.show');//TODO


//routes per gestione entity
Route::get('/entities', 'EntityController@index')->name('entities.index');//TODO
Route::get('/entity/{entityId}', 'EntityController@show')->name('entities.show');//TODO
