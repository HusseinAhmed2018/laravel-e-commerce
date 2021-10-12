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

Route::get('/', 'IndexController@index');

Auth::routes();

Route::get('/home', 'IndexController@index')->name('home');
Route::get('/cart-details', 'CartController@index')->name('cart');

/**
 * Store Routs
 * */
Route::group(['prefix' => 'store','middleware' => ['auth','check.usertype:Merchant']],function () {
    Route::get('/', 'Store\StoreController@index')->name('store');
    Route::post('/', 'Store\StoreController@store')->name('stores.store');
    Route::get('/create', 'Store\StoreController@edit')->name('store.edit');
    Route::put('/{slug}/edit', 'Store\StoreController@update')->name('store.update');
});

/**
 * products route
 * */
Route::group(['prefix' => 'product','middleware' => ['auth','check.usertype:Merchant']],function () {
    Route::get('/', 'Product\ProductController@index')->name('products');
    Route::get('/fetch_products', 'Product\ProductController@get_products')->name('products.ajax');
    Route::get('/create', 'Product\ProductController@create')->name('products.create');
    Route::get('{id}/edit', 'Product\ProductController@edit')->name('products.edit');
    Route::post('/store', 'Product\ProductController@store')->name('products.store');
    Route::put('/{slug}/edit', 'Product\ProductController@update')->name('products.update');
    Route::delete('{id}/destroy', 'Product\ProductController@destroy')->name('product.destroy');
});

/**
 * profile route
 * */
Route::group(['prefix' => 'profile','middleware' => ['auth']],function () {
    Route::get('/', 'Users\SettingController@index')->name('profile');

    Route::put('/update', 'Users\SettingController@update')->name('profile.update');
});

Route::get('store/{slug}/products', 'Store\StoreController@fetchProducts')->name('store.products');
Route::get('cart', 'Store\CartController@index')->name('cart');

