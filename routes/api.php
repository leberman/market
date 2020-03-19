<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * group api v1 routes under
 * Api\v1 directory in controllers
 */
Route::group(['prefix' => 'v1', 'middleware' => ['api','json.response'] , 'namespace' => 'Api\v1'], function () {
    Route::post('login','LoginController@login')->name('login');
    Route::post('register','RegisterController@register')->name('register');
});

//Customer Routes
Route::group(['prefix' => 'v1/customer', 'middleware' => ['auth:api','json.response','role:customer'] , 'namespace' => 'Api\v1\Customer'], function () {
    Route::get('products','ProductController@index')->name('customer.products');
});

//Administrator Routes
Route::group(['prefix' => 'v1/administrator', 'middleware' => ['auth:api','json.response','role:administrator'] , 'namespace' => 'Api\v1\Administrator'], function () {
    Route::resource('user','UserController')->only(['index','show','update']);
    Route::resource('customer','CustomerController');
});

//Seller Routes
Route::group(['prefix' => 'v1/seller', 'middleware' => ['auth:api','json.response','role:seller'] , 'namespace' => 'Api\v1\Seller'], function () {
    Route::resource('product','ProductController')->only('index','store');
});