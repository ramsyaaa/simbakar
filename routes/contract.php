<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contract\CoalContractController;
use App\Http\Controllers\Contract\BbmBookContractController;


Route::group(['middleware' => ['auth'], 'prefix' => 'contracts', 'as' => 'contracts.'], function () {
    Route::group(['prefix' => 'coal-contracts', 'as' => 'coal-contracts.' ,'middleware' => 'permission:kontrak-batu-bara'], function () {
        Route::get('', [CoalContractController::class,'index'])->name('index');
        Route::get('/create', [CoalContractController::class,'create'])->name('create');
        Route::post('/store', [CoalContractController::class,'store'])->name('store');
        Route::get('/edit/{uuid}', [CoalContractController::class,'edit'])->name('edit');
        Route::patch('/edit/{uuid}', [CoalContractController::class,'update'])->name('update');
        Route::delete('/delete/{uuid}', [CoalContractController::class,'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'bbm-book-contracts', 'as' => 'bbm-book-contracts.' ,'middleware' => 'permission:kontrak-pemesanan-bbm'], function () {
        Route::get('', [BbmBookContractController::class,'index'])->name('index');
        Route::get('/create', [BbmBookContractController::class,'create'])->name('create');
        Route::post('/store', [BbmBookContractController::class,'store'])->name('store');
        Route::get('/edit/{uuid}', [BbmBookContractController::class,'edit'])->name('edit');
        Route::patch('/edit/{uuid}', [BbmBookContractController::class,'update'])->name('update');
        Route::delete('/delete/{uuid}', [BbmBookContractController::class,'destroy'])->name('destroy');
    });
});