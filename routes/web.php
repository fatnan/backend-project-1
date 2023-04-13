<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/sum_deep', ['App\Http\Controllers\BackendController', 'sum_deep']);
Route::get('/get_scheme', ['App\Http\Controllers\BackendController', 'get_scheme']);
Route::get('/pattern_count', ['App\Http\Controllers\BackendController', 'pattern_count']);
Route::get('/ship', ['App\Http\Controllers\BackendController', 'ship']);
