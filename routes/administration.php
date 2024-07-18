<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administration\RoleController;
use App\Http\Controllers\Administration\DashboardController;

Route::group(['middleware' => ['auth'], 'prefix' => 'administration', 'as' => 'administration.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'users', 'as' => 'users.','middleware' => 'permission:administration-user'], function () {
        Route::get('', 'Administration\UserController@index')->name('index');
        Route::get('/create', 'Administration\UserController@create')->name('create');
        Route::post('', 'Administration\UserController@store')->name('store');
        Route::get('/export', 'Administration\UserController@export')->name('export-data');
        Route::delete('/{uuid}', 'Administration\UserController@destroy')->name('destroy');
        Route::get('/{uuid}', 'Administration\UserController@edit')->name('edit');
        Route::put('/{uuid}', 'Administration\UserController@update')->name('update');
    }); 

    Route::group(['prefix' => 'roles', 'as' => 'roles.' ,'middleware' => 'permission:administration-role'], function () {
        Route::get('', [RoleController::class,'index'])->name('index');
        Route::get('/create', [RoleController::class,'create'])->name('create');
        Route::post('/store', [RoleController::class,'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class,'edit'])->name('edit');
        Route::patch('/edit/{id}', [RoleController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class,'destroy'])->name('destroy');
    });
});