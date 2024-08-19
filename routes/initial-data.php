<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InitialData\SettingBpbController;
use App\Http\Controllers\InitialData\YearStartDataController;
use App\Http\Controllers\InitialData\BbmReceiptPlanController;
use App\Http\Controllers\InitialData\CoalReceiptPlanController;
use App\Http\Controllers\InitialData\ConsumptionPlanController;
use App\Http\Controllers\InitialData\ElectricityProductionController;

Route::group(['middleware' => ['auth'], 'prefix' => 'initial-data', 'as' => 'initial-data.'], function () {
    Route::group(['prefix' => 'settings-bpb', 'as' => 'settings-bpb.', 'middleware' => 'permission:inisiasi-setting-pbb'], function () {
        Route::get('', [SettingBpbController::class, 'index'])->name('index');
        Route::get('/create', [SettingBpbController::class, 'create'])->name('create');
        Route::post('', [SettingBpbController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [SettingBpbController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [SettingBpbController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [SettingBpbController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'electricity-production', 'as' => 'electricity-production.', 'middleware' => 'permission:inisiasi-produksi-listrik'], function () {
        Route::get('', [ElectricityProductionController::class, 'index'])->name('index');
        Route::get('create', [ElectricityProductionController::class, 'create'])->name('create');
        Route::post('store', [ElectricityProductionController::class, 'store'])->name('store');
        Route::get('/{uuid}', [ElectricityProductionController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ElectricityProductionController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'year-start', 'as' => 'year-start.', 'middleware' => 'permission:inisiasi-data-awal-tahun'], function () {
        Route::get('', [YearStartDataController::class, 'index'])->name('index');
        Route::get('create', [YearStartDataController::class, 'create'])->name('create');
        Route::post('store', [YearStartDataController::class, 'store'])->name('store');
        Route::get('/{uuid}', [YearStartDataController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [YearStartDataController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'coal-receipt-plan', 'as' => 'coal-receipt-plan.', 'middleware' => 'permission:inisiasi-penerimaan-batu-bara'], function () {
        Route::get('', [CoalReceiptPlanController::class, 'index'])->name('index');
        Route::get('create', [CoalReceiptPlanController::class, 'create'])->name('create');
        Route::post('store', [CoalReceiptPlanController::class, 'store'])->name('store');
        Route::get('/{uuid}', [CoalReceiptPlanController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [CoalReceiptPlanController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'consuption-plan', 'as' => 'consuption-plan.', 'middleware' => 'permission:inisiasi-pemakaian'], function () {
        Route::get('', [ConsumptionPlanController::class, 'index'])->name('index');
        Route::get('create', [ConsumptionPlanController::class, 'create'])->name('create');
        Route::post('store', [ConsumptionPlanController::class, 'store'])->name('store');
        Route::get('/{uuid}', [ConsumptionPlanController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ConsumptionPlanController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'bbm-receipt-plan', 'as' => 'bbm-receipt-plan.', 'middleware' => 'permission:inisiasi-pemakaian-bbm'], function () {
        Route::get('', [BbmReceiptPlanController::class, 'index'])->name('index');
        Route::get('create', [BbmReceiptPlanController::class, 'create'])->name('create');
        Route::post('store', [BbmReceiptPlanController::class, 'store'])->name('store');
        Route::get('/{uuid}', [BbmReceiptPlanController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [BbmReceiptPlanController::class, 'update'])->name('update');
    });
});