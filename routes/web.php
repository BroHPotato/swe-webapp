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
Route::post('/settings', 'SettingsController@updateAlerts')->name('settings.updateAlerts');
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
Route::get('/gateways', 'GatewayController@index')->name('gateways.index');//TODO
Route::get('/gateways/create', 'GatewayController@create')->name('gateways.create');//TODO
//Route::get('/gateways', 'GatewayController@store')->name('gateways.store');//TODO
Route::get('/gateways/{gatewayId}', 'GatewayController@show')->name('gateways.show');//TODO
//Route::get('/gateways/{gatewayId}', 'GatewayController@update')->name('gateways.update');//TODO
Route::get('/gateways/{gatewayId}/edit', 'GatewayController@edit')->name('gateways.edit');//TODO

//routes per gestione devices
Route::get('/devices', 'DeviceController@index')->name('devices.index');
Route::get('/devices/create', 'DeviceController@create')->name('devices.create');//TODO
Route::post('/devices', 'DeviceController@store')->name('devices.store');//TODO
Route::get('/devices/{deviceId}', 'DeviceController@show')->name('devices.show');//TODO
Route::put('/devices/{deviceId}', 'DeviceController@update')->name('devices.update');//TODO
Route::get('/devices/{deviceId}/edit', 'DeviceController@edit')->name('devices.edit');//TODO

//routes per gestione sensori
Route::get('/devices/{deviceId}/sensors', 'SensorController@index')->name('sensors.index');//TODO
Route::get('/devices/{deviceId}/sensors/{sensorId}', 'SensorController@show')->name('sensors.show');//TODO

//routes per gestione entity
Route::get('/entities', 'EntityController@index')->name('entities.index');//TODO
Route::get('/entities/create', 'EntityController@create')->name('entities.create');//TODO
Route::post('/entities', 'EntityController@store')->name('entities.store');//TODO
Route::get('/entity/{entityName}', 'EntityController@show')->name('entities.show');//TODO
Route::put('/entity/{entityId}', 'EntityController@update')->name('entities.update');//TODO
Route::get('/entity/{entityName}/edit', 'EntityController@edit')->name('entities.edit');//TODO

//routes per la gestione delle views
Route::get('/views', 'ViewController@index')->name('views.index');//TODO
Route::get('/views/{viewId}', 'ViewController@show')->name('views.show');//TODO
Route::post('/views', 'ViewController@store')->name('views.store');
Route::delete('/views/{viewId}', 'ViewController@destroy')->name('views.destroy');
//data
Route::get('/data/{sensorId}', 'SensorController@fetch')->name('sensors.fetch');//TODO

//logs
Route::get('/logs', 'LogsController@index')->name('logs.index');//TODO
Route::get('/logs/{logId}', 'LogsController@show')->name('logs.show');//TODO
/*->middleware('can:isAdmin')*/// limita users agli admin
Route::post('/viewGraphs/{viewId}', 'GraphsController@store')->name('graphs.store');
Route::delete('/viewGraphs/{viewGraphId}', 'GraphsController@destroy')->name('graphs.destroy');
/*Route::put('/viewGraphs/{viewId}', 'GraphsController@update')->name('graphs.update');*/
