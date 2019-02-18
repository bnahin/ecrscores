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
Route::get('/login-google', 'GoogleAuthController@redirect')->name('login');
Route::get('/oauth-callback', 'GoogleAuthController@handle')->name('oauth-callback');

/** Admin Select */
Route::get('/admin-select', 'AdminController@index')->name('admin-select');
Route::post('/admin/login', 'AdminController@adminLogin')->name('admin-login');

/** Logout */
Route::get('/logout', 'LoginController@logout')->name('logout')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'ViewController@index')->name('home');
    Route::get('/view/{data}', 'ViewController@course')->name('view-course');
});

/** AJAX */
Route::post('/ajax/getTableData', 'AjaxController@getTableData');
Route::post('/ajax/getCellData', 'AjaxController@getCellData');
Route::post('/ajax/getSparklines', 'AjaxController@getAllSparklines');
Route::post('/ajax/getPSATAverages', 'AjaxController@getPSATAverages');
Route::post('/ajax/getSBACAverages', 'AjaxController@getSBACAverages');

/** Homepage Charts */
Route::get('/ajax/getLevels/{level}', 'ChartsController@getLevels');
Route::get('/ajax/getAverages/{exam}', 'ChartsController@getAverages');