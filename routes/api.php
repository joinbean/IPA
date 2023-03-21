<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');

Route::apiResource('shops', 'App\Http\Controllers\ShopController');
Route::apiResource('products', 'App\Http\Controllers\ProductController');
Route::get('products/sort/name', 'App\Http\Controllers\ProductController@sortName');
Route::get('products/sort/shop', 'App\Http\Controllers\ProductController@sortShop');
Route::post('products/filter/shop', 'App\Http\Controllers\ProductController@filterShop');
Route::apiResource('orderProducts', 'App\Http\Controllers\OrderProductController');
Route::get('orders/sort/date/old', 'App\Http\Controllers\OrderController@sortDateAsc');
Route::get('orders/sort/date/new', 'App\Http\Controllers\OrderController@sortDateDesc');
Route::get('orders/sort/status', 'App\Http\Controllers\OrderController@sortStatus');
Route::get('orders/filter/status/open', 'App\Http\Controllers\OrderController@filterStatusOpen');
Route::get('orders/filter/status/closed', 'App\Http\Controllers\OrderController@filterStatusClosed');
Route::apiResource('orders', 'App\Http\Controllers\OrderController');
