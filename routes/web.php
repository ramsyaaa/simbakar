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
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('dashboard');
Route::get('/login', 'Auth\LoginController@index')->name('login')->middleware('guest');
Route::post('/login', 'Auth\LoginController@authenticate')->name('authenticate')->middleware('guest');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth'], 'prefix' => 'settings', 'as' => 'settings.',], function () {
    Route::get('change-password', 'Settings\ChangePasswordController@index')->name('change-password');
    Route::post('change-password', 'Settings\ChangePasswordController@changePassword')->name('change-password.post');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'administration', 'as' => 'administration.'], function () {
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('', 'Administration\UserController@index')->name('index');
        Route::get('/create', 'Administration\UserController@create')->name('create');
        Route::post('', 'Administration\UserController@store')->name('store');
        Route::get('/export', 'Administration\UserController@export')->name('export-data');
        Route::delete('/{uuid}', 'Administration\UserController@destroy')->name('destroy');
        Route::get('/{uuid}', 'Administration\UserController@edit')->name('edit');
        Route::put('/{uuid}', 'Administration\UserController@update')->name('update');
    });
});
