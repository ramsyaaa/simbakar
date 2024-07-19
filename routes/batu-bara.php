<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Coal\CoalUsageController;
use App\Http\Controllers\Coal\CoalReceiptController;
use App\Http\Controllers\Coal\CoalUnloadingController;
use App\Http\Controllers\Coal\CoalUnloadingDisruptionController;

Route::group(['middleware' => ['auth'], 'prefix' => 'coals', 'as' => 'coals.'], function () {

    Route::group(['prefix' => 'unloadings', 'as' => 'unloadings.','middleware' => 'permission:batu-bara-pembongkaran'], function () {

        Route::get('', [CoalUnloadingController::class, 'index'])->name('index');
        Route::get('/create', [CoalUnloadingController::class, 'create'])->name('create');
        Route::post('', [CoalUnloadingController::class, 'store'])->name('store');
        Route::get('/{id}', [CoalUnloadingController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [CoalUnloadingController::class, 'update'])->name('update');
        Route::delete('/{id}', [CoalUnloadingController::class, 'destroy'])->name('destroy');

        Route::get('/disruptions/{unloadingId}', [CoalUnloadingDisruptionController::class, 'index'])->name('disruptions.index');
        Route::get('/disruptions/{unloadingId}/create', [CoalUnloadingDisruptionController::class, 'create'])->name('disruptions.create');
        Route::post('/disruptions/{unloadingId}', [CoalUnloadingDisruptionController::class, 'store'])->name('disruptions.store');
        Route::get('/disruptions/{unloadingId}/{id}', [CoalUnloadingDisruptionController::class, 'edit'])->name('disruptions.edit');
        Route::patch('/disruptions/{unloadingId}/{id}', [CoalUnloadingDisruptionController::class, 'update'])->name('disruptions.update');
        Route::delete('/disruptions/{unloadingId}/{id}', [CoalUnloadingDisruptionController::class, 'destroy'])->name('disruptions.destroy');

    });
    Route::group(['prefix' => 'receipts', 'as' => 'receipts.','middleware' => 'permission:batu-bara-penerimaan'], function () {

        Route::get('', [CoalReceiptController::class, 'index'])->name('index');
        Route::get('/create', [CoalReceiptController::class, 'create'])->name('create');
        Route::post('', [CoalReceiptController::class, 'store'])->name('store');
        Route::get('/{id}', [CoalReceiptController::class, 'edit'])->name('edit');
        Route::get('/quality/{id}', [CoalReceiptController::class, 'quality'])->name('quality');
        Route::patch('/tug/{id}', [CoalReceiptController::class, 'updateTug'])->name('update-tug');
        Route::patch('/detail/{id}', [CoalReceiptController::class, 'updateDetail'])->name('update-detail');
        Route::delete('/{id}', [CoalReceiptController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'usages', 'as' => 'usages.','middleware' => 'permission:batu-bara-pemakaian'], function () {

        Route::get('', [CoalUsageController::class, 'index'])->name('index');
        Route::get('/create', [CoalUsageController::class, 'create'])->name('create');
        Route::post('', [CoalUsageController::class, 'store'])->name('store');
        Route::get('/{id}', [CoalUsageController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [CoalUsageController::class, 'update'])->name('update');
        Route::delete('/{id}', [CoalUsageController::class, 'destroy'])->name('destroy');
    });
});
