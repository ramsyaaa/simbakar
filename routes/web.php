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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', 'Auth\LoginController@index')->name('login')->middleware('guest');
Route::post('/login', 'Auth\LoginController@authenticate')->name('authenticate')->middleware('guest');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/users', 'Administration\UserController@index')->name('users.index')->middleware('auth');
Route::get('settings/change-password', 'Settings\ChangePasswordController@index')->name('settings.change-password')->middleware('auth');
Route::post('settings/change-password', 'Settings\ChangePasswordController@changePassword')->name('settings.change-password.post')->middleware('auth');
