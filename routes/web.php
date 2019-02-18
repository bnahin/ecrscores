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

/** Login */
Route::middleware('guest')->group(function () {
    Route::get('/login-google', 'GoogleAuthController@redirect')->name('login');
    Route::get('/oauth-callback', 'GoogleAuthController@handle')->name('oauth-callback');
});

/** Admin Select */
Route::middleware('admin')->group(function () {
    Route::get('/admin-select', 'AdminController@index')->name('admin-select');
    Route::post('/admin/login', 'AdminController@adminLogin')->name('admin-login');
});


Route::middleware('auth')->group(function () {
    /** Logout */
    Route::get('/logout', 'LoginController@logout')->name('logout');

    /** View Data */
    Route::get('/', 'ViewController@index')->name('home');
    Route::get('/view/{data}', 'ViewController@course')->name('view-course');

    /** AJAX */
    Route::prefix('ajax')->group(function () {
        Route::post('getTableData', 'AjaxController@getTableData');
        Route::post('getCellData', 'AjaxController@getCellData');
        Route::post('getSparklines', 'AjaxController@getAllSparklines');
        Route::post('getPSATAverages', 'AjaxController@getPSATAverages');
        Route::post('getSBACAverages', 'AjaxController@getSBACAverages');

        /** Homepage Charts */
        Route::get('getLevels/{level}', 'ChartsController@getLevels');
        Route::get('getAverages/{exam}', 'ChartsController@getAverages');
    });
});