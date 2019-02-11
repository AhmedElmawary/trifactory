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

Route::get('/', 'HomeController@index');

Route::get('/events', 'EventsController@index');

Route::get('/event-details/{id}', 'EventsController@details');
Route::get('/event-details/getTicketsByRaceId/{id}', 'EventsController@getTicketsByRaceId');
Route::get('/event-details/getMetaByRaceId/{id}', 'EventsController@getMetaByRaceId');

Route::get('/purchase-voucher', function () {
    return view('purchase-voucher');
});

Route::post('/buy-vouchers', 'PaymentController@index');
Route::get('/payment/processedCallback', 'PaymentController@processedCallback');
Route::get('/payment/invoice', 'PaymentController@invoice');

Route::get('/cart', 'CartController@index');
Route::get('/cart/empty', 'CartController@emptyCart');
Route::post('/cart', 'CartController@addToCart');



Route::get('/test', 'HomeController@test');