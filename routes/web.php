<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MasterData\DockController;
use App\Http\Controllers\Administration\RoleController;
use App\Http\Controllers\MasterData\LoadTypeController;
use App\Http\Controllers\MasterData\Ship\ShipController;
use App\Http\Controllers\Administration\DashboardController;
use App\Http\Controllers\MasterData\HarborController;
use App\Http\Controllers\MasterData\LoadingCompanyController;
use App\Http\Controllers\MasterData\Ship\TypeShipController;
use App\Http\Controllers\MasterData\ShipAgentController;
use App\Http\Controllers\Settings\Variabels\BbmPriceController;
use App\Http\Controllers\Settings\Variabels\PriceKsoTaxController;
use App\Http\Controllers\Settings\Variabels\PriceAreaTaxController;
use App\Http\Controllers\Settings\Variabels\ElectricPriceController;
use App\Http\Controllers\Settings\Variabels\ShipUnloadPriceController;
use App\Http\Controllers\Settings\Variabels\ElectricKwhPriceController;
use App\Http\Controllers\Settings\Variabels\BbmTransportPriceController;
use App\Http\Controllers\Settings\Variabels\HarborServicePriceController;
use App\Http\Controllers\MasterData\SupplierController;
use App\Http\Controllers\MasterData\TransporterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/login', 'Auth\LoginController@index')->name('login')->middleware('guest');
Route::post('/login', 'Auth\LoginController@authenticate')->name('authenticate')->middleware('guest');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth'], 'prefix' => 'settings', 'as' => 'settings.',], function () {
    Route::get('change-password', 'Settings\ChangePasswordController@index')->name('change-password');
    Route::post('change-password', 'Settings\ChangePasswordController@changePassword')->name('change-password.post');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'administration', 'as' => 'administration.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('', 'Administration\UserController@index')->name('index');
        Route::get('/create', 'Administration\UserController@create')->name('create');
        Route::post('', 'Administration\UserController@store')->name('store');
        Route::get('/export', 'Administration\UserController@export')->name('export-data');
        Route::delete('/{uuid}', 'Administration\UserController@destroy')->name('destroy');
        Route::get('/{uuid}', 'Administration\UserController@edit')->name('edit');
        Route::put('/{uuid}', 'Administration\UserController@update')->name('update');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('', [RoleController::class,'index'])->name('index');
        Route::get('/create', [RoleController::class,'create'])->name('create');
        Route::post('/store', [RoleController::class,'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class,'edit'])->name('edit');
        Route::patch('/edit/{id}', [RoleController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class,'destroy'])->name('destroy');
    });
});

Route::group(['middleware' => ['auth'], 'prefix' => 'master-data', 'as' => 'master-data.'], function () {
    Route::group(['prefix' => 'ships', 'as' => 'ships.'], function () {
        Route::group(['prefix' => 'type-ship', 'as' => 'type-ship.'], function () {
            Route::get('', [TypeShipController::class, 'index'])->name('index');
            Route::get('/create', [TypeShipController::class, 'create'])->name('create');
            Route::post('', [TypeShipController::class, 'store'])->name('store');
            Route::delete('/{uuid}', [TypeShipController::class, 'destroy'])->name('destroy');
            Route::get('/{uuid}', [TypeShipController::class, 'edit'])->name('edit');
            Route::put('/{uuid}', [TypeShipController::class, 'update'])->name('update');
        });

        Route::get('', [ShipController::class, 'index'])->name('index');
        Route::get('/create', [ShipController::class, 'create'])->name('create');
        Route::post('', [ShipController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [ShipController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [ShipController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ShipController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'load-type', 'as' => 'load-type.'], function () {
        Route::get('', [LoadTypeController::class, 'index'])->name('index');
        Route::get('/create', [LoadTypeController::class, 'create'])->name('create');
        Route::post('', [LoadTypeController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [LoadTypeController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [LoadTypeController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [LoadTypeController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'docks', 'as' => 'docks.'], function () {
        Route::get('', [DockController::class, 'index'])->name('index');
        Route::get('/create', [DockController::class, 'create'])->name('create');
        Route::post('', [DockController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [DockController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [DockController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [DockController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'suppliers', 'as' => 'suppliers.'], function () {
        Route::get('', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('', [SupplierController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [SupplierController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [SupplierController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'ship-agents', 'as' => 'ship-agents.'], function () {
        Route::get('', [ShipAgentController::class, 'index'])->name('index');
        Route::get('/create', [ShipAgentController::class, 'create'])->name('create');
        Route::post('', [ShipAgentController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [ShipAgentController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [ShipAgentController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ShipAgentController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'load-companies', 'as' => 'load-companies.'], function () {
        Route::get('', [LoadingCompanyController::class, 'index'])->name('index');
        Route::get('/create', [LoadingCompanyController::class, 'create'])->name('create');
        Route::post('', [LoadingCompanyController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [LoadingCompanyController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [LoadingCompanyController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [LoadingCompanyController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'transporters', 'as' => 'transporters.'], function () {
        Route::get('', [TransporterController::class, 'index'])->name('index');
        Route::get('/create', [TransporterController::class, 'create'])->name('create');
        Route::post('', [TransporterController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [TransporterController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [TransporterController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [TransporterController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'harbors', 'as' => 'harbors.'], function () {
        Route::get('', [HarborController::class, 'index'])->name('index');
        Route::get('/create', [HarborController::class, 'create'])->name('create');
        Route::post('', [HarborController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [HarborController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [HarborController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [HarborController::class, 'update'])->name('update');
    });

});
Route::group(['middleware' => ['auth'], 'prefix' => 'settings', 'as' => 'settings.'], function () {
    Route::group(['prefix' => 'bbm-prices', 'as' => 'bbm-prices.'], function () {
        Route::get('', [BbmPriceController::class, 'index'])->name('index');
        Route::get('/create', [BbmPriceController::class, 'create'])->name('create');
        Route::post('', [BbmPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [BbmPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [BbmPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [BbmPriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'harbor-service-prices', 'as' => 'harbor-service-prices.'], function () {
        Route::get('', [HarborServicePriceController::class, 'index'])->name('index');
        Route::get('/create', [HarborServicePriceController::class, 'create'])->name('create');
        Route::post('', [HarborServicePriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [HarborServicePriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [HarborServicePriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [HarborServicePriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'bbm-transport-prices', 'as' => 'bbm-transport-prices.'], function () {
        Route::get('', [BbmTransportPriceController::class, 'index'])->name('index');
        Route::get('/create', [BbmTransportPriceController::class, 'create'])->name('create');
        Route::post('', [BbmTransportPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [BbmTransportPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [BbmTransportPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [BbmTransportPriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'price-area-taxes', 'as' => 'price-area-taxes.'], function () {
        Route::get('', [PriceAreaTaxController::class, 'index'])->name('index');
        Route::get('/create', [PriceAreaTaxController::class, 'create'])->name('create');
        Route::post('', [PriceAreaTaxController::class, 'store'])->name('store');
        Route::get('/{uuid}', [PriceAreaTaxController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [PriceAreaTaxController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [PriceAreaTaxController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'price-kso-taxes', 'as' => 'price-kso-taxes.'], function () {
        Route::get('', [PriceKsoTaxController::class, 'index'])->name('index');
        Route::get('/create', [PriceKsoTaxController::class, 'create'])->name('create');
        Route::post('', [PriceKsoTaxController::class, 'store'])->name('store');
        Route::get('/{uuid}', [PriceKsoTaxController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [PriceKsoTaxController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [PriceKsoTaxController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'electric-prices', 'as' => 'electric-prices.'], function () {
        Route::get('', [ElectricPriceController::class, 'index'])->name('index');
        Route::get('/create', [ElectricPriceController::class, 'create'])->name('create');
        Route::post('', [ElectricPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [ElectricPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ElectricPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [ElectricPriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'electric-kwh-prices', 'as' => 'electric-kwh-prices.'], function () {
        Route::get('', [ElectricKwhPriceController::class, 'index'])->name('index');
        Route::get('/create', [ElectricKwhPriceController::class, 'create'])->name('create');
        Route::post('', [ElectricKwhPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [ElectricKwhPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ElectricKwhPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [ElectricKwhPriceController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'ship-unload-prices', 'as' => 'ship-unload-prices.'], function () {
        Route::get('', [ShipUnloadPriceController::class, 'index'])->name('index');
        Route::get('/create', [ShipUnloadPriceController::class, 'create'])->name('create');
        Route::post('', [ShipUnloadPriceController::class, 'store'])->name('store');
        Route::get('/{uuid}', [ShipUnloadPriceController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ShipUnloadPriceController::class, 'update'])->name('update');
        Route::delete('/{uuid}', [ShipUnloadPriceController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/users', 'Administration\UserController@index')->name('users.index')->middleware('auth');
Route::get('settings/change-password', 'Settings\ChangePasswordController@index')->name('settings.change-password')->middleware('auth');
Route::post('settings/change-password', 'Settings\ChangePasswordController@changePassword')->name('settings.change-password.post')->middleware('auth');

