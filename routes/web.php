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

/** In Sync */
Route::get('/errors/sync', function() {
    return view('insync');
})->name('in-sync');
/** Login */
Route::get('/login-google', 'GoogleAuthController@redirect')->name('login');
Route::get('/oauth-callback', 'GoogleAuthController@handle')->name('oauth-callback');

/** Logout */
Route::get('/logout', 'SessionController@logout')->name('logout')->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'ViewController@index')->name('home');
    Route::get('/view/{data}', 'ViewController@course')->name('view-course');
});

/** AJAX */
