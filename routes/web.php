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

Route::get('/', 'DashboardController@show');
Route::get('/dashboard', 'DashboardController@show');
// Route::get('/dashboard/analytics', 'DashboardController@showAnalytics');
// Route::get('/dashboard/data', 'DashboardController@showData');

// API endpoint
Route::get('/api', 'ApiController@index');
Route::post('/api/record', 'ApiController@store');
Route::get('/api/record', 'ApiController@get');