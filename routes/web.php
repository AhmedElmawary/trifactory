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

Route::get('/privacy-policy', function () {
    return view('/privacy-policy');
});

Route::post('/buy-vouchers', 'PaymentController@buyVouchers')->middleware('verified');
Route::post('/buy-tickets', 'PaymentController@buyTickets')->middleware('verified');
Route::post('/refund-ticket', 'PaymentController@refundTicket')->name('refund-ticket')->middleware('verified');

Route::post('/payment/processedCallback', 'PaymentController@processedCallback');
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
Route::get('/getUser', 'ProfileController@getUser');
Route::get('/phoneValidation', 'ProfileController@validatePhone');
Route::get('/sendmailqrcode/{event}', 'ProfileController@resendqrcode');
Route::post('/profile/image', 'ProfileController@image');
Route::post('/profile/update', 'ProfileController@update');
Route::post('/profile/userraceanswers/update', 'ProfileController@updateUserRaceAnswers')->name('questionanswerupdate');
Route::post('/profile/password', 'ProfileController@password');

Route::get('/leaderboard/', 'LeaderboardController@index');
Route::get('/leaderboard/{year}', 'LeaderboardController@indexWithYear');
Route::get('/leaderboard/details', 'LeaderboardController@details');


Auth::routes(['verify' => true]);
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/test', 'HomeController@test');

use Illuminate\Support\Facades\Schema;
use App\TelescopeEntries;
use App\TelescopeEntriesTags;

Route::get('/empty-telescope', function () {
    Schema::disableForeignKeyConstraints();
    TelescopeEntries::truncate();
    TelescopeEntriesTags::truncate();
    Schema::enableForeignKeyConstraints();
    return "Done!";
});

use App\DatabaseStorage;

Route::get('/empty-cart_storage', function () {
    Schema::disableForeignKeyConstraints();
    DatabaseStorage::truncate();
    Schema::enableForeignKeyConstraints();
    return "Done!";
});

Route::get('/payment_success', function () {
    $order = App\Order::find(Illuminate\Support\Facades\Input::get('order'));
    if (\Request::is('api*') || \Request::wantsJson()) {
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'payment-success',
            'data' => $order
        ]);
    } else {
        return view('payment-success', ['order' => $order]);
    }
})->name('payment_success');

Route::get('/download_id_images_zip', function () {
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 3000);
    ini_set('max_input_time', 3000);
    ini_set("default_socket_timeout", 3000);

    $user = \Illuminate\Support\Facades\Auth::user();
    // Download the folder that contains the ID Images of participants
    if (\Illuminate\Support\Facades\Auth::user() && ($user->id == 465 || $user->id == 469)) {
        $public_dir = storage_path('app/public/tickets_images');
        \Zipper::make(storage_path('app/tickets_images_backup/id_images.zip'))->add($public_dir)->close();
        if (\Illuminate\Support\Facades\Auth::user()) {
            return response()
                ->download(storage_path('app/tickets_images_backup/id_images.zip'), 'id_images.zip');
        }
    } else {
        abort(404);
    }
})->name('download_id_images_zip')->middleware('verified');
