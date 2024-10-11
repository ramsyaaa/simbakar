<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiFetchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'v1/user'], function () {
    Route::get('get-user', 'API\UserController@fetchAllUser');
    Route::get('user-detail', 'API\UserController@userDetail');

});


Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    Route::post('authenticate', 'AuthController@authenticate')->name('api.authenticate');
    Route::post('register', 'AuthController@register')->name('api.register');

    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::post('save-inspection', [ApiFetchController::class, 'saveInspection'])->name('saveInspection');
Route::post('save-warehouse', [ApiFetchController::class, 'saveWarehouse'])->name('saveWarehouse');
Route::post('save-manager', [ApiFetchController::class, 'saveManager'])->name('saveManager');
Route::post('save-disruption', [ApiFetchController::class, 'saveDisruption'])->name('saveDisruption');
Route::post('get-contract', [ApiFetchController::class, 'getContract'])->name('getContract');
Route::post('get-number', [ApiFetchController::class, 'getNumber'])->name('getNumber');
Route::post('get-supplier-contract', [ApiFetchController::class, 'getSupplierContract'])->name('getSupplierContract');
Route::get('get-certificate', [ApiFetchController::class, 'getCertificate'])->name('getCertificate');
Route::post('get-contract-ship', [ApiFetchController::class, 'getContractShip'])->name('getContractShip');
Route::post('get-sub-supplier', [ApiFetchController::class, 'getSubSupplier'])->name('getSubSupplier');
Route::post('get-loading-company', [ApiFetchController::class, 'getLoadingCompany'])->name('getLoadingCompany');
Route::post('get-analytic-loading', [ApiFetchController::class, 'getAnalyticLoading'])->name('getAnalyticLoading');
Route::post('get-analytic-unloading', [ApiFetchController::class, 'getAnalyticUnloading'])->name('getAnalyticUnloading');
Route::post('get-analytic-labor', [ApiFetchController::class, 'getAnalyticLabor'])->name('getAnalyticLabor');
Route::post('get-ship', [ApiFetchController::class, 'getShip'])->name('getShip');
Route::post('get-ship-comparisan', [ApiFetchController::class, 'getShipComparison'])->name('getShipComparison');
Route::get('get-supplier-contract/{supplier_id}', [ApiFetchController::class, 'getSupplierContract'])->name('getSupplierContract');
Route::get('chart-data-receipt', [ApiFetchController::class, 'chartDataReceipt'])->name('chartDataReceipt');
