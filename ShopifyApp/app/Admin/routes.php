<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    
    $router->resource('shop', 'ShopController');
    
    $router->resource('extension', 'ExtensionController');
    
    $router->resource('app', 'AppController');
    
    Route::get('/settings', 'SettingsController@index')->name('settings.index');
    
    Route::get('/get_app_list', 'SettingsController@get_app_list');

});
