<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contract\BbmTransferController;
use App\Http\Controllers\Contract\CoalContractController;
use App\Http\Controllers\Contract\PenaltyClauseController;
use App\Http\Controllers\Contract\DeliveryClauseController;
use App\Http\Controllers\Contract\RefusalPenaltyController;
use App\Http\Controllers\Contract\AdjusmentClauseController;
use App\Http\Controllers\Contract\BbmBookContractController;
use App\Http\Controllers\Contract\BiomassaContractController;
use App\Http\Controllers\Contract\Adendum\CoalAdendumController;
use App\Http\Controllers\Contract\BiomassaSubSupplierController;
use App\Http\Controllers\Contract\BiomassaPenaltyClauseController;
use App\Http\Controllers\Contract\BiomassaDeliveryClauseController;
use App\Http\Controllers\Contract\BiomassaAdjusmentClauseController;
use App\Http\Controllers\Contract\SpesificationCoalContractController;
use App\Http\Controllers\Contract\Adendum\AdendumPenaltyClauseController;
use App\Http\Controllers\Contract\Adendum\AdendumDeliveryClauseController;
use App\Http\Controllers\Contract\SpesificationBiomassaContractController;
use App\Http\Controllers\Contract\Adendum\AdendumAdjusmentClauseController;
use App\Http\Controllers\Contract\Adendum\AdendumSpesificationCoalContractController;


Route::group(['middleware' => ['auth'], 'prefix' => 'contracts', 'as' => 'contracts.'], function () {
    Route::group(['prefix' => 'coal-contracts', 'as' => 'coal-contracts.' ,'middleware' => 'permission:kontrak-batu-bara'], function () {
        
        Route::get('', [CoalContractController::class,'index'])->name('index');
        Route::get('/create', [CoalContractController::class,'create'])->name('create');
        Route::post('/store', [CoalContractController::class,'store'])->name('store');
        Route::get('/edit/{uuid}', [CoalContractController::class,'edit'])->name('edit');
        Route::patch('/edit/{uuid}', [CoalContractController::class,'update'])->name('update');
        Route::delete('/delete/{uuid}', [CoalContractController::class,'destroy'])->name('destroy');

        Route::get('/spesification/{contractId}', [SpesificationCoalContractController::class,'index'])->name('spesification.index');
        Route::get('/spesification/{contractId}/create', [SpesificationCoalContractController::class,'create'])->name('spesification.create');
        Route::post('/spesification/{contractId}/store', [SpesificationCoalContractController::class,'store'])->name('spesification.store');
        Route::get('/spesification/{contractId}/edit/{id}', [SpesificationCoalContractController::class,'edit'])->name('spesification.edit');
        Route::patch('/spesification/{contractId}/edit/{id}', [SpesificationCoalContractController::class,'update'])->name('spesification.update');
        Route::delete('/spesification/{contractId}/delete/{id}', [SpesificationCoalContractController::class,'destroy'])->name('spesification.destroy');

        Route::get('/delivery-clause/{contractId}', [DeliveryClauseController::class,'index'])->name('delivery-clause.index');
        Route::get('/delivery-clause/{contractId}/create', [DeliveryClauseController::class,'create'])->name('delivery-clause.create');
        Route::post('/delivery-clause/{contractId}/store', [DeliveryClauseController::class,'store'])->name('delivery-clause.store');
        Route::get('/delivery-clause/{contractId}/edit/{id}', [DeliveryClauseController::class,'edit'])->name('delivery-clause.edit');
        Route::patch('/delivery-clause/{contractId}/edit/{id}', [DeliveryClauseController::class,'update'])->name('delivery-clause.update');
        Route::delete('/delivery-clause/{contractId}/delete/{id}', [DeliveryClauseController::class,'destroy'])->name('delivery-clause.destroy');

        Route::get('/adjusment-clause/{contractId}', [AdjusmentClauseController::class,'index'])->name('adjusment-clause.index');
        Route::get('/adjusment-clause/{contractId}/create', [AdjusmentClauseController::class,'create'])->name('adjusment-clause.create');
        Route::post('/adjusment-clause/{contractId}/store', [AdjusmentClauseController::class,'store'])->name('adjusment-clause.store');
        Route::get('/adjusment-clause/{contractId}/edit/{id}', [AdjusmentClauseController::class,'edit'])->name('adjusment-clause.edit');
        Route::patch('/adjusment-clause/{contractId}/edit/{id}', [AdjusmentClauseController::class,'update'])->name('adjusment-clause.update');
        Route::delete('/adjusment-clause/{contractId}/delete/{id}', [AdjusmentClauseController::class,'destroy'])->name('adjusment-clause.destroy');

        Route::get('/refusal-penalty/{contractId}', [RefusalPenaltyController::class,'index'])->name('refusal-penalty.index');
        Route::get('/refusal-penalty/{contractId}/create', [RefusalPenaltyController::class,'create'])->name('refusal-penalty.create');
        Route::post('/refusal-penalty/{contractId}/store', [RefusalPenaltyController::class,'store'])->name('refusal-penalty.store');
        Route::get('/refusal-penalty/{contractId}/edit/{id}', [RefusalPenaltyController::class,'edit'])->name('refusal-penalty.edit');
        Route::patch('/refusal-penalty/{contractId}/edit/{id}', [RefusalPenaltyController::class,'update'])->name('refusal-penalty.update');
        Route::delete('/refusal-penalty/{contractId}/delete/{id}', [RefusalPenaltyController::class,'destroy'])->name('refusal-penalty.destroy');
        
        Route::get('/penalty-clause/{contractId}', [PenaltyClauseController::class,'index'])->name('penalty-clause.index');
        Route::get('/penalty-clause/{contractId}/create', [PenaltyClauseController::class,'create'])->name('penalty-clause.create');
        Route::post('/penalty-clause/{contractId}/store', [PenaltyClauseController::class,'store'])->name('penalty-clause.store');
        Route::get('/penalty-clause/{contractId}/edit/{id}', [PenaltyClauseController::class,'edit'])->name('penalty-clause.edit');
        Route::patch('/penalty-clause/{contractId}/edit/{id}', [PenaltyClauseController::class,'update'])->name('penalty-clause.update');
        Route::delete('/penalty-clause/{contractId}/delete/{id}', [PenaltyClauseController::class,'destroy'])->name('penalty-clause.destroy');

      
        
    });
    Route::group(['prefix' => 'adendum-coal-contracts', 'as' => 'adendum-coal-contracts.' ,'middleware' => 'permission:kontrak-batu-bara'], function () {
        
        Route::get('{contractId}', [CoalAdendumController::class,'index'])->name('index');
        Route::get('/{contractId}/create', [CoalAdendumController::class,'create'])->name('create');
        Route::get('/{contractId}/create/{adendumId}', [CoalAdendumController::class,'createContract'])->name('createContract');
        Route::post('/{contractId}/store', [CoalAdendumController::class,'store'])->name('store');
        Route::post('/{contractId}/store/{adendumId}', [CoalAdendumController::class,'storeContract'])->name('storeContract');
        Route::get('/{contractId}/edit/{id}', [CoalAdendumController::class,'edit'])->name('edit');
        Route::patch('/{contractId}/edit/{id}', [CoalAdendumController::class,'update'])->name('update');
        Route::delete('{contractId}/delete/{id}', [CoalAdendumController::class,'destroy'])->name('destroy');

        Route::get('/spesification/{adendumId}', [AdendumSpesificationCoalContractController::class,'index'])->name('spesification.index');
        Route::get('/spesification/{adendumId}/create', [AdendumSpesificationCoalContractController::class,'create'])->name('spesification.create');
        Route::post('/spesification/adendumId}/store{', [AdendumSpesificationCoalContractController::class,'store'])->name('spesification.store');
        Route::get('/spesification/{adendumId}/edit/{id}', [AdendumSpesificationCoalContractController::class,'edit'])->name('spesification.edit');
        Route::patch('/spesification/{adendumId}/edit/{id}', [AdendumSpesificationCoalContractController::class,'update'])->name('spesification.update');
        Route::delete('/spesification/{adendumId}/delete/{id}', [AdendumSpesificationCoalContractController::class,'destroy'])->name('spesification.destroy');

        Route::get('/delivery-clause/{adendumId}', [AdendumDeliveryClauseController::class,'index'])->name('delivery-clause.index');
        Route::get('/delivery-clause/{adendumId}/create', [AdendumDeliveryClauseController::class,'create'])->name('delivery-clause.create');
        Route::post('/delivery-clause/{adendumId}/store', [AdendumDeliveryClauseController::class,'store'])->name('delivery-clause.store');
        Route::get('/delivery-clause/{adendumId}/edit/{id}', [AdendumDeliveryClauseController::class,'edit'])->name('delivery-clause.edit');
        Route::patch('/delivery-clause/{adendumId}/edit/{id}', [AdendumDeliveryClauseController::class,'update'])->name('delivery-clause.update');
        Route::delete('/delivery-clause/{adendumId}/delete/{id}', [AdendumDeliveryClauseController::class,'destroy'])->name('delivery-clause.destroy');

        Route::get('/adjusment-clause/{adendumId}', [AdendumAdjusmentClauseController::class,'index'])->name('adjusment-clause.index');
        Route::get('/adjusment-clause/{adendumId}/create', [AdendumAdjusmentClauseController::class,'create'])->name('adjusment-clause.create');
        Route::post('/adjusment-clause/{adendumId}/store', [AdendumAdjusmentClauseController::class,'store'])->name('adjusment-clause.store');
        Route::get('/adjusment-clause/{adendumId}/edit/{id}', [AdendumAdjusmentClauseController::class,'edit'])->name('adjusment-clause.edit');
        Route::patch('/adjusment-clause/{adendumId}/edit/{id}', [AdendumAdjusmentClauseController::class,'update'])->name('adjusment-clause.update');
        Route::delete('/adjusment-clause/{adendumId}/delete/{id}', [AdendumAdjusmentClauseController::class,'destroy'])->name('adjusment-clause.destroy');

        Route::get('/penalty-clause/{adendumId}', [AdendumPenaltyClauseController::class,'index'])->name('penalty-clause.index');
        Route::get('/penalty-clause/{adendumId}/create', [AdendumPenaltyClauseController::class,'create'])->name('penalty-clause.create');
        Route::post('/penalty-clause/{adendumId}/store', [AdendumPenaltyClauseController::class,'store'])->name('penalty-clause.store');
        Route::get('/penalty-clause/{adendumId}/edit/{id}', [AdendumPenaltyClauseController::class,'edit'])->name('penalty-clause.edit');
        Route::patch('/penalty-clause/{adendumId}/edit/{id}', [AdendumPenaltyClauseController::class,'update'])->name('penalty-clause.update');
        Route::delete('/penalty-clause/{adendumId}/delete/{id}', [AdendumPenaltyClauseController::class,'destroy'])->name('penalty-clause.destroy');
        
    });
   
    Route::group(['prefix' => 'bbm-book-contracts', 'as' => 'bbm-book-contracts.' ,'middleware' => 'permission:kontrak-pemesanan-bbm'], function () {
        Route::get('', [BbmBookContractController::class,'index'])->name('index');
        Route::get('/create', [BbmBookContractController::class,'create'])->name('create');
        Route::post('/store', [BbmBookContractController::class,'store'])->name('store');
        Route::get('/edit/{uuid}', [BbmBookContractController::class,'edit'])->name('edit');
        Route::patch('/edit/{uuid}', [BbmBookContractController::class,'update'])->name('update');
        Route::delete('/delete/{uuid}', [BbmBookContractController::class,'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'bbm-transfers', 'as' => 'bbm-transfers.' ,'middleware' => 'permission:kontrak-transfer-bbm'], function () {
        Route::get('', [BbmTransferController::class,'index'])->name('index');
        Route::get('/create', [BbmTransferController::class,'create'])->name('create');
        Route::post('/store', [BbmTransferController::class,'store'])->name('store');
        Route::get('/edit/{id}', [BbmTransferController::class,'edit'])->name('edit');
        Route::patch('/edit/{id}', [BbmTransferController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [BbmTransferController::class,'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'biomassa-contracts', 'as' => 'biomassa-contracts.'], function () {
        
        Route::get('', [BiomassaContractController::class,'index'])->name('index');
        Route::get('/create', [BiomassaContractController::class,'create'])->name('create');
        Route::post('/store', [BiomassaContractController::class,'store'])->name('store');
        Route::get('/edit/{uuid}', [BiomassaContractController::class,'edit'])->name('edit');
        Route::patch('/edit/{uuid}', [BiomassaContractController::class,'update'])->name('update');
        Route::delete('/delete/{uuid}', [BiomassaContractController::class,'destroy'])->name('destroy');

        Route::get('/spesification/{contractId}', [SpesificationBiomassaContractController::class,'index'])->name('spesification.index');
        Route::get('/spesification/{contractId}/create', [SpesificationBiomassaContractController::class,'create'])->name('spesification.create');
        Route::post('/spesification/{contractId}/store', [SpesificationBiomassaContractController::class,'store'])->name('spesification.store');
        Route::get('/spesification/{contractId}/edit/{id}', [SpesificationBiomassaContractController::class,'edit'])->name('spesification.edit');
        Route::patch('/spesification/{contractId}/edit/{id}', [SpesificationBiomassaContractController::class,'update'])->name('spesification.update');
        Route::delete('/spesification/{contractId}/delete/{id}', [SpesificationBiomassaContractController::class,'destroy'])->name('spesification.destroy');

        Route::get('/delivery-clause/{contractId}', [BiomassaDeliveryClauseController::class,'index'])->name('delivery-clause.index');
        Route::get('/delivery-clause/{contractId}/create', [BiomassaDeliveryClauseController::class,'create'])->name('delivery-clause.create');
        Route::post('/delivery-clause/{contractId}/store', [BiomassaDeliveryClauseController::class,'store'])->name('delivery-clause.store');
        Route::get('/delivery-clause/{contractId}/edit/{id}', [BiomassaDeliveryClauseController::class,'edit'])->name('delivery-clause.edit');
        Route::patch('/delivery-clause/{contractId}/edit/{id}', [BiomassaDeliveryClauseController::class,'update'])->name('delivery-clause.update');
        Route::delete('/delivery-clause/{contractId}/delete/{id}', [BiomassaDeliveryClauseController::class,'destroy'])->name('delivery-clause.destroy');

        Route::get('/adjusment-clause/{contractId}', [BiomassaAdjusmentClauseController::class,'index'])->name('adjusment-clause.index');
        Route::get('/adjusment-clause/{contractId}/create', [BiomassaAdjusmentClauseController::class,'create'])->name('adjusment-clause.create');
        Route::post('/adjusment-clause/{contractId}/store', [BiomassaAdjusmentClauseController::class,'store'])->name('adjusment-clause.store');
        Route::get('/adjusment-clause/{contractId}/edit/{id}', [BiomassaAdjusmentClauseController::class,'edit'])->name('adjusment-clause.edit');
        Route::patch('/adjusment-clause/{contractId}/edit/{id}', [BiomassaAdjusmentClauseController::class,'update'])->name('adjusment-clause.update');
        Route::delete('/adjusment-clause/{contractId}/delete/{id}', [BiomassaAdjusmentClauseController::class,'destroy'])->name('adjusment-clause.destroy');

        Route::get('/penalty-clause/{contractId}', [BiomassaPenaltyClauseController::class,'index'])->name('penalty-clause.index');
        Route::get('/penalty-clause/{contractId}/create', [BiomassaPenaltyClauseController::class,'create'])->name('penalty-clause.create');
        Route::post('/penalty-clause/{contractId}/store', [BiomassaPenaltyClauseController::class,'store'])->name('penalty-clause.store');
        Route::get('/penalty-clause/{contractId}/edit/{id}', [BiomassaPenaltyClauseController::class,'edit'])->name('penalty-clause.edit');
        Route::patch('/penalty-clause/{contractId}/edit/{id}', [BiomassaPenaltyClauseController::class,'update'])->name('penalty-clause.update');
        Route::delete('/penalty-clause/{contractId}/delete/{id}', [BiomassaPenaltyClauseController::class,'destroy'])->name('penalty-clause.destroy');

        Route::get('/sub-supplier/{contractId}', [BiomassaSubSupplierController::class,'index'])->name('sub-supplier.index');
        Route::get('/sub-supplier/{contractId}/create', [BiomassaSubSupplierController::class,'create'])->name('sub-supplier.create');
        Route::post('/sub-supplier/{contractId}/store', [BiomassaSubSupplierController::class,'store'])->name('sub-supplier.store');
        Route::get('/sub-supplier/{contractId}/edit/{id}', [BiomassaSubSupplierController::class,'edit'])->name('sub-supplier.edit');
        Route::patch('/sub-supplier/{contractId}/edit/{id}', [BiomassaSubSupplierController::class,'update'])->name('sub-supplier.update');
        Route::delete('/sub-supplier/{contractId}/delete/{id}', [BiomassaSubSupplierController::class,'destroy'])->name('sub-supplier.destroy');
        
    });
});