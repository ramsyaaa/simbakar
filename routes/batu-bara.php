<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Coal\CoalUsageController;
use App\Http\Controllers\Coal\CoalReceiptController;
use App\Http\Controllers\Coal\CoalUnloadingController;
use App\Http\Controllers\Coal\FuelAdjusmentIncomeController;
use App\Http\Controllers\Coal\FuelAdjusmentOutcomeController;
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
        Route::get('/loading/{id}', [CoalReceiptController::class, 'analyticLoading'])->name('analytic-loading');
        Route::get('/unloading/{id}', [CoalReceiptController::class, 'analyticUnloading'])->name('analytic-unloading');
        Route::get('/labor/{id}', [CoalReceiptController::class, 'analyticLabor'])->name('analytic-labor');
    });

    Route::group(['prefix' => 'usages', 'as' => 'usages.','middleware' => 'permission:batu-bara-pemakaian'], function () {

        Route::get('', [CoalUsageController::class, 'index'])->name('index');
        Route::get('/create', [CoalUsageController::class, 'create'])->name('create');
        Route::post('', [CoalUsageController::class, 'store'])->name('store');
        Route::get('/{id}', [CoalUsageController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [CoalUsageController::class, 'update'])->name('update');
        Route::delete('/{id}', [CoalUsageController::class, 'destroy'])->name('destroy');

        Route::get('/adjusment-incomes/index', [FuelAdjusmentIncomeController::class, 'index'])->name('adjusment-incomes.index');
        Route::get('/adjusment-incomes/create', [FuelAdjusmentIncomeController::class, 'create'])->name('adjusment-incomes.create');
        Route::post('/adjusment-incomes', [FuelAdjusmentIncomeController::class, 'store'])->name('adjusment-incomes.store');
        Route::get('/adjusment-incomes/edit/{id}', [FuelAdjusmentIncomeController::class, 'edit'])->name('adjusment-incomes.edit');
        Route::patch('/adjusment-incomes/{id}', [FuelAdjusmentIncomeController::class, 'update'])->name('adjusment-incomes.update');
        Route::delete('/adjusment-incomes/{id}', [FuelAdjusmentIncomeController::class, 'destroy'])->name('adjusment-incomes.destroy');

        Route::get('/adjusment-outcomes/index', [FuelAdjusmentOutcomeController::class, 'index'])->name('adjusment-outcomes.index');
        Route::get('/adjusment-outcomes/create', [FuelAdjusmentOutcomeController::class, 'create'])->name('adjusment-outcomes.create');
        Route::post('/adjusment-outcomes', [FuelAdjusmentOutcomeController::class, 'store'])->name('adjusment-outcomes.store');
        Route::get('/adjusment-outcomes/edit/{id}', [FuelAdjusmentOutcomeController::class, 'edit'])->name('adjusment-outcomes.edit');
        Route::patch('/adjusment-outcomes/{id}', [FuelAdjusmentOutcomeController::class, 'update'])->name('adjusment-outcomes.update');
        Route::delete('/adjusment-outcomes/{id}', [FuelAdjusmentOutcomeController::class, 'destroy'])->name('adjusment-outcomes.destroy');
    });
});
