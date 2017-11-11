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

Route::get('/getDistrict/{id}', 'HomeController@getDistrict');
Route::get('/getDistrictApi/{id}', 'HomeController@getDistrictApi');
Route::get('/getTown/{id}', 'HomeController@getTown');
Route::get('/getTownApi/{id}', 'HomeController@getTownApi');
Route::post('/getHotelInTown', 'HomeController@getHotelInTown');