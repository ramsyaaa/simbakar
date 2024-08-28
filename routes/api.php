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
Route::post('get-certificate', [ApiFetchController::class, 'getCertificate'])->name('getCertificate');
Route::post('get-contract-ship', [ApiFetchController::class, 'getContractShip'])->name('getContractShip');
