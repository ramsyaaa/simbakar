<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\BW\BWController;
use App\Http\Controllers\Report\Receipt\ReceiptController;
use App\Http\Controllers\Report\Receipt\CoalBLController;
use App\Http\Controllers\Report\Contract\ContractController;
use App\Http\Controllers\Report\Supplies\SuppliesController;
use App\Http\Controllers\Report\Unloading\UnloadingController;
use App\Http\Controllers\Report\Contract\SpotMonthlyController;
use App\Http\Controllers\Report\BeritaAcara\BeritaAcaraController;
use App\Http\Controllers\Report\CoalQuality\CoalAllItemController;
use App\Http\Controllers\Report\CoalQuality\CoalQualityController;
use App\Http\Controllers\Report\Contract\EvaluationCoalController;
use App\Http\Controllers\Report\Contract\MonitoringCoalController;
use App\Http\Controllers\Report\Performance\PerformanceController;
use App\Http\Controllers\Report\Contract\CoalAllContractController;
use App\Http\Controllers\Report\Unloading\DisruptionDataController;
use App\Http\Controllers\Report\Unloading\OperationalDuksController;
use App\Http\Controllers\Report\CoalQuality\CoalComparisonController;
use App\Http\Controllers\Report\ExecutiveSummary\ReportBbmController;
use App\Http\Controllers\Report\Receipt\CoalMonthlyReceiptController;
use App\Http\Controllers\Report\Contract\CoalRecapitulationController;
use App\Http\Controllers\Report\CoalQuality\CoalCalorMonthlyController;
use App\Http\Controllers\Report\CoalQuality\CoalCalorSupplierController;
use App\Http\Controllers\Report\HeavyEquipment\HeavyEquipmentController;
use App\Http\Controllers\Report\Receipt\ReceiptRecapitulationController;
use App\Http\Controllers\Report\ShipMonitoring\ShipMonitoringController;
use App\Http\Controllers\Report\Unloading\CoalUnloadingReportController;
use App\Http\Controllers\Report\ExecutiveSummary\ExecutiveSummaryController;
use App\Http\Controllers\Report\Contract\CoalReceiptRecapitulationController;
use App\Http\Controllers\Report\ExecutiveSummary\MonitoringSupplierController;
use App\Http\Controllers\Report\Contract\PlanAndReazlitionCoalMonthlyController;
use App\Http\Controllers\Report\ExecutiveSummary\MonitoringCoalAnalyticController;
use App\Http\Controllers\Report\Contract\PlanAndReazlitionCoalMonthlySpotController;
use App\Http\Controllers\Report\Unloading\HsdCarUnloadingController;

Route::group(['middleware' => ['auth'], 'prefix' => 'reports', 'as' => 'reports.'], function () {
    Route::group(['prefix' => 'executive-summary', 'as' => 'executive-summary.'], function () {
        Route::get('', [ExecutiveSummaryController::class, 'index'])->name('index');
        Route::get('bbm-receipt-usage-report/{type}', [ReportBbmController::class, 'index'])->name('bbm-receipt-usage');
        Route::post('bbm-receipt-usage-report/{type}', [ReportBbmController::class, 'index'])->name('bbm-receipt-usage');

        // no 1
        Route::get('bbm-monthly-realitation-contract-plan', [ReportBbmController::class, 'bbmMonthlyRealitationContractPlan'])->name('bbm-monthly-realitation-contract-plan');
        Route::post('bbm-monthly-realitation-contract-plan', [ReportBbmController::class, 'bbmMonthlyRealitationContractPlan'])->name('bbm-monthly-realitation-contract-plan');

        // no 2
        Route::get('bbm-monthly-usage-realitation', [ReportBbmController::class, 'bbmMonthlyUsageRealitation'])->name('bbm-monthly-usage-realitation');
        Route::post('bbm-monthly-usage-realitation', [ReportBbmController::class, 'bbmMonthlyUsageRealitation'])->name('bbm-monthly-usage-realitation');

        // no 3
        Route::get('bbm-realitation-cumulative-stock', [ReportBbmController::class, 'bbmRealitationCumulativeStock'])->name('bbm-realitation-cumulative-stock');
        Route::post('bbm-realitation-cumulative-stock', [ReportBbmController::class, 'bbmRealitationCumulativeStock'])->name('bbm-realitation-cumulative-stock');


        // no 4
        Route::get('bbm-loading-unloading-efective-stock', [ReportBbmController::class, 'bbmLoadingUnloadingEfectiveStock'])->name('bbm-loading-unloading-efective-stock');
        Route::post('bbm-loading-unloading-efective-stock', [ReportBbmController::class, 'bbmLoadingUnloadingEfectiveStock'])->name('bbm-loading-unloading-efective-stock');

        // no 11
        Route::get('bbm-unloading-month-comparison', [ReportBbmController::class, 'bbmUnloadingMonthComparison'])->name('bbm-unloading-month-comparison');
        Route::post('bbm-unloading-month-comparison', [ReportBbmController::class, 'bbmUnloadingMonthComparison'])->name('bbm-unloading-month-comparison');

        // no 12
        Route::get('bbm-unloading-month-realitation', [ReportBbmController::class, 'bbmUnloadingMonthRealitation'])->name('bbm-unloading-month-realitation');
        Route::post('bbm-unloading-month-realitation', [ReportBbmController::class, 'bbmUnloadingMonthRealitation'])->name('bbm-unloading-month-realitation');

        Route::get('bbm-usage/{type}/{type_bbm}', [ReportBbmController::class, 'bbmUsageReport'])->name('bbm-usage');
        Route::post('bbm-usage/{type}/{type_bbm}', [ReportBbmController::class, 'bbmUsageReport'])->name('bbm-usage');

        // no 9
        Route::get('monitoring-coal-analytic', [MonitoringCoalAnalyticController::class, 'index'])->name('monitoring-coal-analytic');
        // no 10
        Route::get('monitoring-supplier', [MonitoringSupplierController::class, 'index'])->name('monitoring-supplier');
    });

    Route::group(['prefix' => 'contracts', 'as' => 'contracts.'], function () {
        Route::get('', [ContractController::class, 'index'])->name('index');
        Route::get('coal-monitoring', [MonitoringCoalController::class, 'index'])->name('coal-monitoring');
        Route::get('coal-monthly', [PlanAndReazlitionCoalMonthlyController::class, 'index'])->name('coal-monthly');
        Route::get('coal-monthly-spot', [SpotMonthlyController::class, 'index'])->name('coal-monthly-spot');
        Route::get('coal-recapitulation', [CoalRecapitulationController::class, 'index'])->name('coal-recapitulation');
        Route::get('coal-receipt', [CoalReceiptRecapitulationController::class, 'index'])->name('coal-receipt');
        Route::get('coal-all', [CoalAllContractController::class, 'index'])->name('coal-all');
        Route::get('coal-evaluation', [EvaluationCoalController::class, 'index'])->name('coal-evaluation');
    });

    Route::group(['prefix' => 'supplies', 'as' => 'supplies.'], function () {
        Route::get('', [SuppliesController::class, 'index'])->name('index');

        Route::get('bbm-receipt/coal', [ReportBbmController::class, 'bbmRealitationCumulativeStock'])->name('bbm-receipt-coal');
        Route::post('bbm-receipt/coal', [ReportBbmController::class, 'bbmRealitationCumulativeStock'])->name('bbm-receipt-coal');

        Route::get('bbm-receipt/{bbm_type}', [SuppliesController::class, 'bbmReceipt'])->name('bbm-receipt');
        Route::post('bbm-receipt/{bbm_type}', [SuppliesController::class, 'bbmReceipt'])->name('bbm-receipt');
    });

    Route::group(['prefix' => 'receipt', 'as' => 'receipt.'], function () {
        Route::get('', [ReceiptController::class, 'index'])->name('index');
        Route::get('bbm/{type_bbm}', [ReceiptController::class, 'bbmReceipt'])->name('bbm-receipt.index');
        Route::post('bbm/{type_bbm}', [ReceiptController::class, 'bbmReceipt'])->name('bbm-receipt.index');
        Route::get('coal-recapitulation/', [ReceiptRecapitulationController::class, 'index'])->name('coal-recapitulation.index');
        Route::get('coal-monthly', [CoalMonthlyReceiptController::class, 'index'])->name('coal-monthly.index');
         Route::get('/coal-bl', [CoalBLController::class, 'index'])->name('coal-bl');
    });

    Route::group(['prefix' => 'coal-quality', 'as' => 'coal-quality.'], function () {
        Route::get('', [CoalQualityController::class, 'index'])->name('index');
        Route::get('coal-comparison', [CoalComparisonController::class, 'index'])->name('coal-comparison');
        Route::get('coal-calor-monthly', [CoalCalorMonthlyController::class, 'index'])->name('coal-calor-monthly');
        Route::get('coal-calor-supplier', [CoalCalorSupplierController::class, 'index'])->name('coal-calor-supplier');
        Route::get('coal-all-item', [CoalAllItemController::class, 'index'])->name('coal-all-item');
    });

    Route::group(['prefix' => 'unloading', 'as' => 'unloading.'], function () {
        Route::get('', [UnloadingController::class, 'index'])->name('index');
        Route::get('/hsd-car-unloading', [HsdCarUnloadingController::class, 'index'])->name('hsd-car-unloading');
        Route::get('/operational-duks', [OperationalDuksController::class, 'index'])->name('operational-duks');
        Route::get('/disruption-data', [DisruptionDataController::class, 'index'])->name('disruption-data');
        Route::get('/coal-unloading-report', [CoalUnloadingReportController::class, 'index'])->name('coal-unloading-report');

    });

    Route::group(['prefix' => 'heavy-equipment', 'as' => 'heavy-equipment.'], function () {
        Route::get('{type}/{type_bbm}', [HeavyEquipmentController::class, 'index'])->name('index');
        Route::post('{type}/{type_bbm}', [HeavyEquipmentController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'berita-acara', 'as' => 'berita-acara.'], function () {
        Route::get('', [BeritaAcaraController::class, 'index'])->name('index');
        Route::get('bbm', [BeritaAcaraController::class, 'bbm'])->name('bbm');
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
