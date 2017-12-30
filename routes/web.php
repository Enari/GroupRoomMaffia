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

Route::get('/', function (Request $request) {
    return redirect('/allbookings');
});

// Auth
Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

// Session
Route::get('/sessions', 'KronoxSessionController@index');
Route::get('/sessions/delete/{session}', 'KronoxSessionController@delete');
Route::post('/sessions', 'KronoxSessionController@add');

// Bookings
Route::get('/mybookings', 'BookingsController@index');
Route::get('/bookings/delete/{booker}/{id}', 'BookingsController@unBook');
Route::post('/mybookings', 'BookingsController@book');
Route::get('/allbookings/{date?}', 'BookingsController@allBookings');

// Schedulled Bookings
Route::get('/schedulled', 'SchedulledBookingsController@index');
Route::get('/schedulled/delete/{booking}', 'SchedulledBookingsController@delete');
