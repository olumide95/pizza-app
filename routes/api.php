<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'UsersController@register');
Route::post('/login', 'UsersController@login');

Route::get('/menu', 'MenuController@index');

Route::get('/orders', 'OrderController@index')->middleware('customer');
Route::post('/order', 'OrderController@take_order');