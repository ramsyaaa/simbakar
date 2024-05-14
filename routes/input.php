<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Input\StockOpnameController;

Route::group(['middleware' => ['auth'], 'prefix' => 'inputs', 'as' => 'inputs.'], function () {
    Route::group(['prefix' => 'stock-opnames', 'as' => 'stock-opnames.','middleware' => 'permission:inputan-stock-opname'], function () {
        Route::get('', [StockOpnameController::class, 'index'])->name('index');
        Route::get('/create', [StockOpnameController::class, 'create'])->name('create');
        Route::post('', [StockOpnameController::class, 'store'])->name('store');
        Route::get('/{uuid}', [StockOpnameController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [StockOpnameController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [StockOpnameController::class, 'destroy'])->name('destroy');
    });
});
