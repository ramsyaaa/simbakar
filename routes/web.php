<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

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
    return redirect()->route('admin.dashboard');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::prefix('role')->group(function () {
        Route::get('', 'Admin\RoleController@index')->name('admin.role.index');
        Route::get('/create', 'Admin\RoleController@create')->name('admin.role.create');
        Route::post('/store', 'Admin\RoleController@store')->name('admin.role.store');
        Route::get('/edit/{id}', 'Admin\RoleController@edit')->name('admin.role.edit');
        Route::patch('/edit/{id}', 'Admin\RoleController@update')->name('admin.role.update');
        Route::delete('/delete/{id}', 'Admin\RoleController@destroy')->name('admin.role.destroy');
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class,'index'])->name('admin.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/store', [UserController::class,'store'])->name('admin.user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::patch('edit/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    });
});
Route::get('/users', 'Administration\UserController@index')->name('users.index')->middleware('auth');
Route::get('settings/change-password', 'Settings\ChangePasswordController@index')->name('settings.change-password')->middleware('auth');
Route::post('settings/change-password', 'Settings\ChangePasswordController@changePassword')->name('settings.change-password.post')->middleware('auth');

