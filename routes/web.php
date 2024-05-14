<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MasterData\Dock\DockController;
use App\Http\Controllers\Administration\RoleController;
use App\Http\Controllers\MasterData\LoadTypeController;
use App\Http\Controllers\MasterData\Ship\ShipController;
use App\Http\Controllers\Administration\DashboardController;
use App\Http\Controllers\InitialData\CoalReceiptPlanController;
use App\Http\Controllers\InitialData\ElectricityProductionController;
use App\Http\Controllers\InitialData\SettingBpbController;
use App\Http\Controllers\InitialData\YearStartDataController;
use App\Http\Controllers\MasterData\Bunker\BunkerController;
use App\Http\Controllers\MasterData\Bunker\SoundingController;
use App\Http\Controllers\MasterData\Dock\DockInspectionController;
use App\Http\Controllers\MasterData\Dock\EquipmentController;
use App\Http\Controllers\MasterData\HarborController;
use App\Http\Controllers\MasterData\HeavyEquipment\HeavyEquipmentController;
use App\Http\Controllers\MasterData\HeavyEquipment\HeavyEquipmentTypeController;
use App\Http\Controllers\MasterData\LoadingCompanyController;
use App\Http\Controllers\MasterData\PersonInChargeController;
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
use App\Http\Controllers\MasterData\SurveyorController;
use App\Http\Controllers\MasterData\TransporterController;
use App\Http\Controllers\MasterData\UnitController;

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

Route::group(['middleware' => ['auth'], 'prefix' => 'settings', 'as' => 'settings.','middleware' => 'permission:pengaturan-ubah-password'], function () {
    Route::get('change-password', 'Settings\ChangePasswordController@index')->name('change-password');
    Route::post('change-password', 'Settings\ChangePasswordController@changePassword')->name('change-password.post');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'administration', 'as' => 'administration.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'users', 'as' => 'users.','middleware' => 'permission:administration-user'], function () {
        Route::get('', 'Administration\UserController@index')->name('index');
        Route::get('/create', 'Administration\UserController@create')->name('create');
        Route::post('', 'Administration\UserController@store')->name('store');
        Route::get('/export', 'Administration\UserController@export')->name('export-data');
        Route::delete('/{uuid}', 'Administration\UserController@destroy')->name('destroy');
        Route::get('/{uuid}', 'Administration\UserController@edit')->name('edit');
        Route::put('/{uuid}', 'Administration\UserController@update')->name('update');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.' ,'middleware' => 'permission:administration-role'], function () {
        Route::get('', [RoleController::class,'index'])->name('index');
        Route::get('/create', [RoleController::class,'create'])->name('create');
        Route::post('/store', [RoleController::class,'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class,'edit'])->name('edit');
        Route::patch('/edit/{id}', [RoleController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [RoleController::class,'destroy'])->name('destroy');
    });
});

Route::group(['middleware' => ['auth'], 'prefix' => 'initial-data', 'as' => 'initial-data.'], function () {
    Route::group(['prefix' => 'settings-bpb', 'as' => 'settings-bpb.', 'middleware' => 'permission:inisiasi-setting-pbb'], function () {
        Route::get('', [SettingBpbController::class, 'index'])->name('index');
        Route::get('/create', [SettingBpbController::class, 'create'])->name('create');
        Route::post('', [SettingBpbController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [SettingBpbController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [SettingBpbController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [SettingBpbController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'electricity-production', 'as' => 'electricity-production.', 'middleware' => 'permission:inisiasi-produksi-listrik'], function () {
        Route::get('', [ElectricityProductionController::class, 'index'])->name('index');
        Route::get('/{uuid}', [ElectricityProductionController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ElectricityProductionController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'year-start', 'as' => 'year-start.', 'middleware' => 'permission:inisiasi-data-awal-tahun'], function () {
        Route::get('', [YearStartDataController::class, 'index'])->name('index');
        Route::get('/{uuid}', [YearStartDataController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [YearStartDataController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'coal-receipt-plan', 'as' => 'coal-receipt-plan.', 'middleware' => 'permission:inisiasi-penerimaan-batu-bara'], function () {
        Route::get('', [CoalReceiptPlanController::class, 'index'])->name('index');
        Route::get('/{uuid}', [CoalReceiptPlanController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [CoalReceiptPlanController::class, 'update'])->name('update');
    });
});

Route::group(['middleware' => ['auth'], 'prefix' => 'master-data', 'as' => 'master-data.'], function () {
    Route::group(['prefix' => 'ships', 'as' => 'ships.' ,'middleware' => 'permission:data-kapal'], function () {
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

    Route::group(['prefix' => 'load-type', 'as' => 'load-type.' ,'middleware' => 'permission:data-muatan'], function () {
        Route::get('', [LoadTypeController::class, 'index'])->name('index');
        Route::get('/create', [LoadTypeController::class, 'create'])->name('create');
        Route::post('', [LoadTypeController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [LoadTypeController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [LoadTypeController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [LoadTypeController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'docks', 'as' => 'docks.','middleware' => 'permission:data-dermaga'], function () {
        Route::group(['prefix' => 'equipments', 'as' => 'equipments.'], function () {
            Route::get('', [EquipmentController::class, 'index'])->name('index');
            Route::get('/create', [EquipmentController::class, 'create'])->name('create');
            Route::post('', [EquipmentController::class, 'store'])->name('store');
            Route::delete('/{uuid}', [EquipmentController::class, 'destroy'])->name('destroy');
            Route::get('/{uuid}', [EquipmentController::class, 'edit'])->name('edit');
            Route::put('/{uuid}', [EquipmentController::class, 'update'])->name('update');
        });
        Route::group(['prefix' => 'inspections', 'as' => 'inspections.'], function () {
            Route::get('', [DockInspectionController::class, 'index'])->name('index');
            Route::get('/create', [DockInspectionController::class, 'create'])->name('create');
            Route::post('', [DockInspectionController::class, 'store'])->name('store');
            Route::delete('/{uuid}', [DockInspectionController::class, 'destroy'])->name('destroy');
            Route::get('/{uuid}', [DockInspectionController::class, 'edit'])->name('edit');
            Route::put('/{uuid}', [DockInspectionController::class, 'update'])->name('update');
        });

        Route::get('', [DockController::class, 'index'])->name('index');
        Route::get('/create', [DockController::class, 'create'])->name('create');
        Route::post('', [DockController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [DockController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [DockController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [DockController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'suppliers', 'as' => 'suppliers.','middleware' => 'permission:data-pemasok'], function () {
        Route::get('', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('', [SupplierController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [SupplierController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [SupplierController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'ship-agents', 'as' => 'ship-agents.','middleware' => 'permission:data-agen-kapal'], function () {
        Route::get('', [ShipAgentController::class, 'index'])->name('index');
        Route::get('/create', [ShipAgentController::class, 'create'])->name('create');
        Route::post('', [ShipAgentController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [ShipAgentController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [ShipAgentController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [ShipAgentController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'load-companies', 'as' => 'load-companies.','middleware' => 'permission:data-bongkar-muat'], function () {
        Route::get('', [LoadingCompanyController::class, 'index'])->name('index');
        Route::get('/create', [LoadingCompanyController::class, 'create'])->name('create');
        Route::post('', [LoadingCompanyController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [LoadingCompanyController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [LoadingCompanyController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [LoadingCompanyController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'transporters', 'as' => 'transporters.','middleware' => 'permission:data-transportir'], function () {
        Route::get('', [TransporterController::class, 'index'])->name('index');
        Route::get('/create', [TransporterController::class, 'create'])->name('create');
        Route::post('', [TransporterController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [TransporterController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [TransporterController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [TransporterController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'harbors', 'as' => 'harbors.','middleware' => 'permission:data-pelabuhan-muat'], function () {
        Route::get('', [HarborController::class, 'index'])->name('index');
        Route::get('/create', [HarborController::class, 'create'])->name('create');
        Route::post('', [HarborController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [HarborController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [HarborController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [HarborController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'surveyors', 'as' => 'surveyors.','middleware' => 'permission:data-surveyor'], function () {
        Route::get('', [SurveyorController::class, 'index'])->name('index');
        Route::get('/create', [SurveyorController::class, 'create'])->name('create');
        Route::post('', [SurveyorController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [SurveyorController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [SurveyorController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [SurveyorController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'person-in-charges', 'as' => 'person-in-charges.','middleware' => 'permission:data-pic'], function () {
        Route::get('', [PersonInChargeController::class, 'index'])->name('index');
        Route::get('/create', [PersonInChargeController::class, 'create'])->name('create');
        Route::post('', [PersonInChargeController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [PersonInChargeController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [PersonInChargeController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [PersonInChargeController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'heavy-equipments', 'as' => 'heavy-equipments.','middleware' => 'permission:data-alat'], function () {
        Route::group(['prefix' => 'type', 'as' => 'type.'], function () {
            Route::get('', [HeavyEquipmentTypeController::class, 'index'])->name('index');
            Route::get('/create', [HeavyEquipmentTypeController::class, 'create'])->name('create');
            Route::post('', [HeavyEquipmentTypeController::class, 'store'])->name('store');
            Route::delete('/{uuid}', [HeavyEquipmentTypeController::class, 'destroy'])->name('destroy');
            Route::get('/{uuid}', [HeavyEquipmentTypeController::class, 'edit'])->name('edit');
            Route::put('/{uuid}', [HeavyEquipmentTypeController::class, 'update'])->name('update');
        });

        Route::get('', [HeavyEquipmentController::class, 'index'])->name('index');
        Route::get('/create', [HeavyEquipmentController::class, 'create'])->name('create');
        Route::post('', [HeavyEquipmentController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [HeavyEquipmentController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [HeavyEquipmentController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [HeavyEquipmentController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'bunkers', 'as' => 'bunkers.','middleware' => 'permission:data-bunker-bbm'], function () {
        Route::group(['prefix' => 'soundings', 'as' => 'soundings.'], function () {
            Route::get('{bunker_uuid}', [SoundingController::class, 'index'])->name('index');
            Route::get('{bunker_uuid}/create', [SoundingController::class, 'create'])->name('create');
            Route::post('{bunker_uuid}', [SoundingController::class, 'store'])->name('store');
            Route::delete('{bunker_uuid}/{uuid}', [SoundingController::class, 'destroy'])->name('destroy');
            Route::get('{bunker_uuid}/{uuid}', [SoundingController::class, 'edit'])->name('edit');
            Route::put('{bunker_uuid}/{uuid}', [SoundingController::class, 'update'])->name('update');
        });
        Route::get('', [BunkerController::class, 'index'])->name('index');
        Route::get('/create', [BunkerController::class, 'create'])->name('create');
        Route::post('', [BunkerController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [BunkerController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [BunkerController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [BunkerController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'units', 'as' => 'units.','middleware' => 'permission:data-unit'], function () {
        Route::get('', [UnitController::class, 'index'])->name('index');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('', [UnitController::class, 'store'])->name('store');
        Route::delete('/{uuid}', [UnitController::class, 'destroy'])->name('destroy');
        Route::get('/{uuid}', [UnitController::class, 'edit'])->name('edit');
        Route::put('/{uuid}', [UnitController::class, 'update'])->name('update');
    });

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

