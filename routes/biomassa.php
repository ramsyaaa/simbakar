<?php

use App\Http\Controllers\Biomassa\BiomassaUsageController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth'], 'prefix' => 'biomassa', 'as' => 'biomassa.'], function () {

    Route::group(['prefix' => 'usages', 'as' => 'usages.'], function () {

        Route::get('', [BiomassaUsageController::class, 'index'])->name('index');
        Route::get('/create', [BiomassaUsageController::class, 'create'])->name('create');
        Route::post('', [BiomassaUsageController::class, 'store'])->name('store');
        Route::get('/{id}', [BiomassaUsageController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [BiomassaUsageController::class, 'update'])->name('update');
        Route::delete('/{id}', [BiomassaUsageController::class, 'destroy'])->name('destroy');
    });
});
