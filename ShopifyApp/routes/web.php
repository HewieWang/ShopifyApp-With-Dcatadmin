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

Route::get('/', "App\Http\Controllers\HomeController@index");

Route::get("/checkout-setting","App\Http\Controllers\CheckoutSettingController@index");

Route::get("/api/saker-checkout-config","App\Http\Controllers\CheckoutSettingController@getconfig");

Route::post("/redirect_to_auth", "App\Http\Controllers\HomeController@redirect_to_auth");

Route::get("/get_access_token", "App\Http\Controllers\HomeController@get_access_token");
