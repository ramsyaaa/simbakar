<?php

use App\Http\Controllers\Report\BeritaAcara\BeritaAcaraController;
use App\Http\Controllers\Report\BW\BWController;
use App\Http\Controllers\Report\CoalQuality\CoalQualityController;
use App\Http\Controllers\Report\Contract\ContractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ExecutiveSummary\ExecutiveSummaryController;
use App\Http\Controllers\Report\ExecutiveSummary\ReportBbmController;
use App\Http\Controllers\Report\HeavyEquipment\HeavyEquipmentController;
use App\Http\Controllers\Report\Performance\PerformanceController;
use App\Http\Controllers\Report\Receipt\ReceiptController;
use App\Http\Controllers\Report\ShipMonitoring\ShipMonitoringController;
use App\Http\Controllers\Report\Supplies\SuppliesController;
use App\Http\Controllers\Report\Unloading\UnloadingController;

Route::group(['middleware' => ['auth'], 'prefix' => 'reports', 'as' => 'reports.'], function () {
    Route::group(['prefix' => 'executive-summary', 'as' => 'executive-summary.'], function () {
        Route::get('', [ExecutiveSummaryController::class, 'index'])->name('index');
        Route::get('bbm-receipt-usage-report/{type}', [ReportBbmController::class, 'index'])->name('bbm-receipt-usage');
        Route::post('bbm-receipt-usage-report/{type}', [ReportBbmController::class, 'index'])->name('bbm-receipt-usage');

        Route::get('bbm-usage/{type}/{type_bbm}', [ReportBbmController::class, 'bbmUsageReport'])->name('bbm-usage');
        Route::post('bbm-usage/{type}/{type_bbm}', [ReportBbmController::class, 'bbmUsageReport'])->name('bbm-usage');
    });

    Route::group(['prefix' => 'contracts', 'as' => 'contracts.'], function () {
        Route::get('', [ContractController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'supplies', 'as' => 'supplies.'], function () {
        Route::get('', [SuppliesController::class, 'index'])->name('index');
        Route::get('bbm-receipt/{bbm_type}', [SuppliesController::class, 'bbmReceipt'])->name('bbm-receipt');
        Route::post('bbm-receipt/{bbm_type}', [SuppliesController::class, 'bbmReceipt'])->name('bbm-receipt');
    });

    Route::group(['prefix' => 'receipt', 'as' => 'receipt.'], function () {
        Route::get('', [ReceiptController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'coal-quality', 'as' => 'coal-quality.'], function () {
        Route::get('', [CoalQualityController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'unloading', 'as' => 'unloading.'], function () {
        Route::get('', [UnloadingController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'heavy-equipment', 'as' => 'heavy-equipment.'], function () {
        Route::get('{type}/{type_bbm}', [HeavyEquipmentController::class, 'index'])->name('index');
        Route::post('{type}/{type_bbm}', [HeavyEquipmentController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'berita-acara', 'as' => 'berita-acara.'], function () {
        Route::get('', [BeritaAcaraController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'performance', 'as' => 'performance.'], function () {
        Route::get('', [PerformanceController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'bw', 'as' => 'bw.'], function () {
        Route::get('', [BWController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'ship-monitoring', 'as' => 'ship-monitoring.'], function () {
        Route::get('', [ShipMonitoringController::class, 'index'])->name('index');
    });


});
