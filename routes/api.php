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

Route::group(['middleware' => 'api'], function () {

    Route::get('/old_cart','CartController@old_cart');
    Route::post('/cart','CartController@cart');

    Route::get('/increase/{id}', 'CartController@getIncreaseByOne');
    Route::get('/reduce/{id}', 'CartController@getReduceByOne');
    Route::get('/remove/{id}', 'CartController@getRemoveItem');

});
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
