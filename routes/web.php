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
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/events', 'EventsController@index');

Route::get('/event-details/{id}', 'EventsController@details');
Route::get('/event-details/getTicketsByRaceId/{id}', 'EventsController@getTicketsByRaceId');
Route::get('/event-details/getMetaByRaceId/{id}', 'EventsController@getMetaByRaceId');
Route::get('/event-details/helper/countries', 'EventsController@getCountries');

Route::get('/purchase-voucher', function () {
    return view('purchase-voucher');
});

Route::post('/buy-vouchers', 'PaymentController@buyVouchers')->middleware('verified');
Route::post('/buy-tickets', 'PaymentController@buyTickets')->middleware('verified');

Route::get('/payment/processedCallback', 'PaymentController@processedCallback');
Route::get('/payment/invoice', 'PaymentController@invoice');

Route::get('/cart', 'CartController@index');
Route::get('/cart/empty', 'CartController@emptyCart');
Route::post('/cart', 'CartController@addToCart');
Route::post('/cart/remove', 'CartController@removeFromCart');

Route::get('/cart/payment', 'CartController@payment');
Route::post('/cart/credit', 'CartController@credit');
Route::post('/cart/voucher', 'CartController@voucher');

Route::post('/cart/item/code', 'CartController@itemCode');

Route::get('/profile', 'ProfileController@index')->middleware('verified');
Route::post('/profile/image', 'ProfileController@image');
Route::post('/profile/update', 'ProfileController@update');
Route::post('/profile/password', 'ProfileController@password');

Route::get('/leaderboard', 'LeaderboardController@index')->middleware('verified');

Auth::routes(['verify' => true]);
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/test', 'HomeController@test');
