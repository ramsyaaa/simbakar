<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MasterData\Dock\DockController;
use App\Http\Controllers\Administration\RoleController;
use App\Http\Controllers\MasterData\LoadTypeController;
use App\Http\Controllers\MasterData\Ship\ShipController;
use App\Http\Controllers\Administration\DashboardController;
use App\Http\Controllers\InitialData\BbmReceiptPlanController;
use App\Http\Controllers\InitialData\CoalReceiptPlanController;
use App\Http\Controllers\InitialData\ConsumptionPlanController;
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

require 'administration.php';
require 'initial-data.php';
require 'master-data.php';
require 'input.php';
require 'setting.php';

