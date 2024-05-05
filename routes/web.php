<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Administration\RoleController;
use App\Http\Controllers\Administration\DashboardController;
use App\Http\Controllers\MasterData\DockController;
use App\Http\Controllers\MasterData\LoadTypeController;
use App\Http\Controllers\MasterData\Ship\ShipController;
use App\Http\Controllers\MasterData\Ship\TypeShipController;

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
    return redirect()->route('dashboard');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/login', 'Auth\LoginController@index')->name('login')->middleware('guest');
Route::post('/login', 'Auth\LoginController@authenticate')->name('authenticate')->middleware('guest');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth'], 'prefix' => 'settings', 'as' => 'settings.',], function () {
    Route::get('change-password', 'Settings\ChangePasswordController@index')->name('change-password');
    Route::post('change-password', 'Settings\ChangePasswordController@changePassword')->name('change-password.post');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'administration', 'as' => 'administration.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('', 'Administration\UserController@index')->name('index');
        Route::get('/create', 'Administration\UserController@create')->name('create');
        Route::post('', 'Administration\UserController@store')->name('store');
        Route::get('/export', 'Administration\UserController@export')->name('export-data');
        Route::delete('/{uuid}', 'Administration\UserController@destroy')->name('destroy');
        Route::get('/{uuid}', 'Administration\UserController@edit')->name('edit');
        Route::put('/{uuid}', 'Administration\UserController@update')->name('update');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('', [RoleController::class,'index'])->name('index');
        Route::get('/create', [RoleController::class,'create'])->name('create');
        Route::post('/store', [RoleController::class,'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class,'edit'])->name('edit');
        Route::patch('/edit/{id}', [RoleController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class,'destroy'])->name('destroy');
    });
});

Route::group(['middleware' => ['auth'], 'prefix' => 'master-data', 'as' => 'master-data.'], function () {
    Route::group(['prefix' => 'ships', 'as' => 'ships.'], function () {
        Route::group(['prefix' => 'type-ship', 'as' => 'type-ship.'], function () {
            Route::get('', [TypeShipController::class, 'index'])->name('index');
            Route::get('/create', [TypeShipController::class, 'create'])->name('create');
            Route::post('', [TypeShipController::class, 'store'])->name('store');
            Route::delete('/{uuid}', [TypeShipController::class, 'destroy'])->name('destroy');
            Route::get('/{uuid}', [TypeShipController::class, 'edit'])->name('edit');
            Route::put('/{uuid}', [TypeShipController::class, 'update'])->name('update');
        });

        Route::get('', [ShipController::class, 'index'])->name('index');
        Route::get('/create', [ShipController::class, 'create'])->name('create');
        Route::post('', [ShipController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [ShipController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [ShipController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ShipController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'load-type', 'as' => 'load-type.'], function () {
        Route::get('', [LoadTypeController::class, 'index'])->name('index');
        Route::get('/create', [LoadTypeController::class, 'create'])->name('create');
        Route::post('', [LoadTypeController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [LoadTypeController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [LoadTypeController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [LoadTypeController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'docks', 'as' => 'docks.'], function () {
        Route::get('', [DockController::class, 'index'])->name('index');
        Route::get('/create', [DockController::class, 'create'])->name('create');
        Route::post('', [DockController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [DockController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [DockController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [DockController::class, 'update'])->name('update');
    });
});
Route::get('/users', 'Administration\UserController@index')->name('users.index')->middleware('auth');
Route::get('settings/change-password', 'Settings\ChangePasswordController@index')->name('settings.change-password')->middleware('auth');
Route::post('settings/change-password', 'Settings\ChangePasswordController@changePassword')->name('settings.change-password.post')->middleware('auth');

