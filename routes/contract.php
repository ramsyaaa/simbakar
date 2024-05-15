<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contract\CoalContractController;


Route::group(['middleware' => ['auth'], 'prefix' => 'contracts', 'as' => 'contracts.'], function () {
    Route::group(['prefix' => 'coal-contracts', 'as' => 'coal-contracts.' ,'middleware' => 'permission:kontrak-batu-bara'], function () {
        Route::get('', [CoalContractController::class,'index'])->name('index');
        Route::get('/create', [CoalContractController::class,'create'])->name('create');
        Route::post('/store', [CoalContractController::class,'store'])->name('store');
        Route::get('/edit/{id}', [CoalContractController::class,'edit'])->name('edit');
        Route::patch('/edit/{id}', [CoalContractController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [CoalContractController::class,'destroy'])->name('destroy');
    });
});