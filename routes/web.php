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
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/users/create', 'UserController@create')->name('users.create');//TODO
Route::post('/users', 'UserController@store')->name('users.store');
Route::get('/users/{userId}', 'UserController@show')->name('users.show');//TODO
Route::put('/users/{userId}', 'UserController@update')->name('users.update');
Route::get('/users/{userId}/edit', 'UserController@edit')->name('users.edit');//TODO
Route::put('/users/{userId}/restore', 'UserController@restore')->name('users.restore');
Route::delete('/users/{userId}/delete', 'UserController@destroy')->name('users.destroy');

//routes per gestione gateways
Route::get('/gateways', 'GatewayController@index')->name('gateway.index');//TODO
Route::get('/gateway/{gatewayId}', 'GatewayController@show')->name('gateway.show');//TODO

//routes per gestione devices
Route::get('/devices', 'DeviceController@index')->name('devices.index');
Route::get('/devices/create', 'DeviceController@create')->name('devices.create');//TODO
Route::get('/devices/{deviceId}', 'DeviceController@show')->name('devices.show');//TODO
Route::get('/devices/{deviceId}/edit', 'DeviceController@edit')->name('devices.edit');//TODO


//routes per gestione sensori
Route::get('/devices/{deviceId}/sensors', 'SensorController@index')->name('sensors.index');//TODO
Route::get('/devices/{deviceId}/sensors/{sensorId}', 'SensorController@show')->name('sensors.show');//TODO


//routes per gestione entity
Route::get('/entities', 'EntityController@index')->name('entities.index');//TODO
Route::get('/entities/{entityId}', 'EntityController@show')->name('entities.show');//TODO


//routes per gestione views
Route::get('/views', 'ViewController@index')->name('views.index');//TODO
Route::get('/views/{viewId}', 'ViewController@show')->name('views.show');//TODO

//data
Route::get('/data/devices/{deviceId}/sensors/{sensorId}', 'SensorController@fetch')->name('sensors.fetch');//TODO
/*->middleware('can:isAdmin')*/// limita users agli admin
