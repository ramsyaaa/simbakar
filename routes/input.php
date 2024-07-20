<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tug\TugNineController;
use App\Http\Controllers\Tug\TugThreeController;
use App\Http\Controllers\Input\StockOpnameController;
use App\Http\Controllers\Input\Analysis\LaborController;
use App\Http\Controllers\Input\Analysis\LoadingController;
use App\Http\Controllers\Input\BbmUsage\BbmUsageController;
use App\Http\Controllers\Input\Analysis\UnloadingController;
use App\Http\Controllers\Input\Analysis\PreloadingController;
use App\Http\Controllers\Input\BbmReceipt\BbmReceiptController;

Route::group(['middleware' => ['auth'], 'prefix' => 'inputs', 'as' => 'inputs.'], function () {
    Route::group(['prefix' => 'stock-opnames', 'as' => 'stock-opnames.','middleware' => 'permission:inputan-stock-opname'], function () {
        Route::get('', [StockOpnameController::class, 'index'])->name('index');
        Route::get('/create', [StockOpnameController::class, 'create'])->name('create');
        Route::post('', [StockOpnameController::class, 'store'])->name('store');
        Route::get('/{uuid}', [StockOpnameController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [StockOpnameController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [StockOpnameController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'analysis', 'as' => 'analysis.'], function () {
        Route::group(['prefix' => 'preloadings', 'as' => 'preloadings.'], function () {
            Route::get('', [PreloadingController::class, 'index'])->name('index');
            Route::get('/create', [PreloadingController::class, 'create'])->name('create');
            Route::post('', [PreloadingController::class, 'store'])->name('store');
            Route::get('/{id}', [PreloadingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PreloadingController::class, 'update'])->name('update');
            Route::delete('/{id}', [PreloadingController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => 'loadings', 'as' => 'loadings.'], function () {
            Route::get('', [LoadingController::class, 'index'])->name('index');
            Route::get('/create', [LoadingController::class, 'create'])->name('create');
            Route::post('', [LoadingController::class, 'store'])->name('store');
            Route::get('/{id}', [LoadingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LoadingController::class, 'update'])->name('update');
            Route::delete('/{id}', [LoadingController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => 'labors', 'as' => 'labors.'], function () {
            Route::get('', [LaborController::class, 'index'])->name('index');
            Route::get('/create', [LaborController::class, 'create'])->name('create');
            Route::post('', [LaborController::class, 'store'])->name('store');
            Route::get('/{id}', [LaborController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LaborController::class, 'update'])->name('update');
            Route::delete('/{id}', [LaborController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => 'unloadings', 'as' => 'unloadings.'], function () {
            Route::get('', [UnloadingController::class, 'index'])->name('index');
            Route::get('/create', [UnloadingController::class, 'create'])->name('create');
            Route::post('', [UnloadingController::class, 'store'])->name('store');
            Route::get('/{id}', [UnloadingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UnloadingController::class, 'update'])->name('update');
            Route::delete('/{id}', [UnloadingController::class, 'destroy'])->name('destroy');
        });
    });

    Route::group(['prefix' => 'bbm_receipts', 'as' => 'bbm_receipts.'], function () {
        Route::get('', [BbmReceiptController::class, 'index'])->name('index');
        Route::get('/create', [BbmReceiptController::class, 'create'])->name('create');
        Route::post('', [BbmReceiptController::class, 'store'])->name('store');
        Route::get('/{id}', [BbmReceiptController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BbmReceiptController::class, 'update'])->name('update');
        Route::delete('/{id}', [BbmReceiptController::class, 'destroy'])->name('destroy');
    });
   
    Route::group(['prefix' => 'bbm_usage', 'as' => 'bbm_usage.'], function () {
        Route::get('', [BbmUsageController::class, 'index'])->name('index');
        Route::get('/create', [BbmUsageController::class, 'create'])->name('create');
        Route::post('', [BbmUsageController::class, 'store'])->name('store');
        Route::get('/{id}', [BbmUsageController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BbmUsageController::class, 'update'])->name('update');
        Route::delete('/{id}', [BbmUsageController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'tug-3', 'as' => 'tug-3.'], function () {
        Route::get('', [TugThreeController::class, 'index'])->name('index');
        Route::get('/{id}', [TugThreeController::class, 'detail'])->name('detail');
        Route::delete('/{id}', [TugThreeController::class, 'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'tug-9', 'as' => 'tug-9.'], function () {
        Route::get('/index-coal', [TugNineController::class, 'indexCoal'])->name('index-coal');
    });
});
