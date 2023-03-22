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

Route::apiResource('shops', 'App\Http\Controllers\ShopController')->middleware('auth:sanctum');
Route::apiResource('products', 'App\Http\Controllers\ProductController')->middleware('auth:sanctum');
// Route::post('products/{product}', 'App\Http\Controllers\ProductController@update')->middleware('auth:sanctum');
Route::get('products/sort/name', 'App\Http\Controllers\ProductController@sortName')->middleware('auth:sanctum');
Route::get('products/sort/shop', 'App\Http\Controllers\ProductController@sortShop')->middleware('auth:sanctum');
Route::post('products/filter/shop', 'App\Http\Controllers\ProductController@filterShop')->middleware('auth:sanctum');
Route::apiResource('orderProducts', 'App\Http\Controllers\OrderProductController')->middleware('auth:sanctum');
Route::get('orders/sort/date/old', 'App\Http\Controllers\OrderController@sortDateAsc')->middleware('auth:sanctum');
Route::get('orders/sort/date/new', 'App\Http\Controllers\OrderController@sortDateDesc')->middleware('auth:sanctum');
Route::get('orders/sort/status', 'App\Http\Controllers\OrderController@sortStatus')->middleware('auth:sanctum');
Route::get('orders/filter/status/open', 'App\Http\Controllers\OrderController@filterStatusOpen')->middleware('auth:sanctum');
Route::get('orders/filter/status/closed', 'App\Http\Controllers\OrderController@filterStatusClosed')->middleware('auth:sanctum');
Route::apiResource('orders', 'App\Http\Controllers\OrderController')->middleware('auth:sanctum');
