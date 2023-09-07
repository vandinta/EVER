<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * route "Authorization Users" 
*/
Route::post('/register','App\Http\Controllers\Api\AuthController@register');
Route::post('/login','App\Http\Controllers\Api\AuthController@login');
Route::post('/logout','App\Http\Controllers\Api\AuthController@logout');
Route::get('/users','App\Http\Controllers\Api\AuthController@users');
Route::get('/user/detail/{id}','App\Http\Controllers\Api\AuthController@detail');
Route::post('/user/update','App\Http\Controllers\Api\AuthController@update');

/**
 * route "Jadwal" 
*/
Route::get('/jadwal','App\Http\Controllers\Api\JadwalController@index');
Route::post('/jadwal/create','App\Http\Controllers\Api\JadwalController@create');
Route::get('/jadwal/detail/{id}','App\Http\Controllers\Api\JadwalController@detail');
Route::post('/jadwal/update','App\Http\Controllers\Api\JadwalController@update');
Route::delete('/jadwal/delete/{id}','App\Http\Controllers\Api\JadwalController@delete');

/**
 * route "Booking" 
*/
Route::get('/booking','App\Http\Controllers\Api\BookingController@index');
Route::post('/booking/create','App\Http\Controllers\Api\BookingController@create');
Route::get('/booking/detail/{id}','App\Http\Controllers\Api\BookingController@detail');
Route::post('/booking/update','App\Http\Controllers\Api\BookingController@update');
Route::delete('/booking/delete/{id}','App\Http\Controllers\Api\BookingController@delete');

/**
 * route "kendaraan" 
*/
Route::get('/kendaraan','App\Http\Controllers\Api\KendaraanController@index');
Route::post('/kendaraan/create','App\Http\Controllers\Api\KendaraanController@create');
Route::get('/kendaraan/detail/{id}','App\Http\Controllers\Api\KendaraanController@detail');
Route::post('/kendaraan/update','App\Http\Controllers\Api\KendaraanController@update');
Route::delete('/kendaraan/delete/{id}','App\Http\Controllers\Api\KendaraanController@delete');
