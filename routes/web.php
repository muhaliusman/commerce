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
    return redirect('products');
});

Route::get('products', 'ProductController@index')->name('products.index');
Route::get('discounts', 'DiscountController@index')->name('discounts.index');
Route::get('cart', 'CartController@index')->name('cart.index');
Route::get('cart/total', 'CartController@getTotal')->name('cart.total');
Route::get('cart/products', 'CartController@getProductsInCart')->name('cart.products');
Route::post('cart', 'CartController@store')->name('cart.store');
Route::delete('cart/{product_id}', 'CartController@destroy')->name('cart.destroy');
Route::put('cart/{product_id}/qty', 'CartController@updateQty')->name('cart.update.qty');
Route::put('cart/{product_id}/discount', 'CartController@updateDiscount')->name('cart.update.discount');
Route::post('order', 'OrderController@store')->name('order.store');
Route::get('order', 'OrderController@index')->name('order.index');