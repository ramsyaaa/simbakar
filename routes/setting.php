<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\Variabels\BbmPriceController;
use App\Http\Controllers\Settings\Variabels\PriceKsoTaxController;
use App\Http\Controllers\Settings\Variabels\PriceAreaTaxController;
use App\Http\Controllers\Settings\Variabels\ElectricPriceController;
use App\Http\Controllers\Settings\Variabels\ShipUnloadPriceController;
use App\Http\Controllers\Settings\Variabels\ElectricKwhPriceController;
use App\Http\Controllers\Settings\Variabels\BbmTransportPriceController;
use App\Http\Controllers\Settings\Variabels\HarborServicePriceController;

Route::group(['middleware' => ['auth'], 'prefix' => 'settings', 'as' => 'settings.','middleware' => 'permission:pengaturan-ubah-password'], function () {
    Route::get('change-password', 'Settings\ChangePasswordController@index')->name('change-password');
    Route::post('change-password', 'Settings\ChangePasswordController@changePassword')->name('change-password.post');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'settings', 'as' => 'settings.'], function () {
    Route::group(['prefix' => 'bbm-prices', 'as' => 'bbm-prices.','middleware' => 'permission:variabel-harga-bbm'], function () {
        Route::get('', [BbmPriceController::class, 'index'])->name('index');
        Route::get('/create', [BbmPriceController::class, 'create'])->name('create');
        Route::post('', [BbmPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [BbmPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [BbmPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [BbmPriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'harbor-service-prices', 'as' => 'harbor-service-prices.','middleware' => 'permission:variabel-jasa-dermaga'], function () {
        Route::get('', [HarborServicePriceController::class, 'index'])->name('index');
        Route::get('/create', [HarborServicePriceController::class, 'create'])->name('create');
        Route::post('', [HarborServicePriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [HarborServicePriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [HarborServicePriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [HarborServicePriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'bbm-transport-prices', 'as' => 'bbm-transport-prices.','middleware' => 'permission:variabel-angkut-bbm'], function () {
        Route::get('', [BbmTransportPriceController::class, 'index'])->name('index');
        Route::get('/create', [BbmTransportPriceController::class, 'create'])->name('create');
        Route::post('', [BbmTransportPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [BbmTransportPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [BbmTransportPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [BbmTransportPriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'price-area-taxes', 'as' => 'price-area-taxes.','middleware' => 'permission:variabel-pajak-daerah'], function () {
        Route::get('', [PriceAreaTaxController::class, 'index'])->name('index');
        Route::get('/create', [PriceAreaTaxController::class, 'create'])->name('create');
        Route::post('', [PriceAreaTaxController::class, 'store'])->name('store');
        Route::get('/{uuid}', [PriceAreaTaxController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [PriceAreaTaxController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [PriceAreaTaxController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'price-kso-taxes', 'as' => 'price-kso-taxes.','middleware' => 'permission:variabel-pajak-kso'], function () {
        Route::get('', [PriceKsoTaxController::class, 'index'])->name('index');
        Route::get('/create', [PriceKsoTaxController::class, 'create'])->name('create');
        Route::post('', [PriceKsoTaxController::class, 'store'])->name('store');
        Route::get('/{uuid}', [PriceKsoTaxController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [PriceKsoTaxController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [PriceKsoTaxController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'electric-prices', 'as' => 'electric-prices.','middleware' => 'permission:variabel-tarif-listrik'], function () {
        Route::get('', [ElectricPriceController::class, 'index'])->name('index');
        Route::get('/create', [ElectricPriceController::class, 'create'])->name('create');
        Route::post('', [ElectricPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [ElectricPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ElectricPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [ElectricPriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'electric-kwh-prices', 'as' => 'electric-kwh-prices.','middleware' => 'permission:variabel-tarif-kwh'], function () {
        Route::get('', [ElectricKwhPriceController::class, 'index'])->name('index');
        Route::get('/create', [ElectricKwhPriceController::class, 'create'])->name('create');
        Route::post('', [ElectricKwhPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [ElectricKwhPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ElectricKwhPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [ElectricKwhPriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'ship-unload-prices', 'as' => 'ship-unload-prices.','middleware' => 'permission:variabel-tarif-ship'], function () {
        Route::get('', [ShipUnloadPriceController::class, 'index'])->name('index');
        Route::get('/create', [ShipUnloadPriceController::class, 'create'])->name('create');
        Route::post('', [ShipUnloadPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [ShipUnloadPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ShipUnloadPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [ShipUnloadPriceController::class, 'destroy'])->name('destroy');
    });
});