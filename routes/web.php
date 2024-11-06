<?php

use App\BbmReceipt;
use App\BbmUsage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Scheduling\SchedulingPlanController;
use App\Ship;

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

Route::get('/change-type-bbm', function(){
    $noTug9Array = [
        '000502.....',
        '006123.....',
        '006151.....',
        '006152.....',
        '006163......',
        '006164.....',
        '006165.....',
        '006172......',
        '006175.....',
        '008457......',
        '008463......',
        '008471....',
        '008480......',
        '008645.....',
        '008695.......',
        '008697......',
        '009115.....',
        '009119......',
        '009120......',
        '009121.....',
        '009124......',
        '009127.......',
        '009128......',
        '009130.....',
        '009134......',
        '009135......',
        '009136......',
        '009137......',
        '017027......',
        '017066......',
        '017071....',
        '017073......',
        '017075......',
        '017078.....',
        '017080.....',
        '017082.....',
        '017083......',
        '017086.......',
        '017088......',
        '017092.....',
        '0181056.....',
        '018154....',
        '018157......',
        '018160.......',
        '018164.....',
        '018165......',
        '018227.....',
        '018228.....',
        '018232.....',
        '018233......',
        '018235......',
        '018236.....',
        '018238......',
        '018239......',
        '084464',
        '222222',
        '33333'
    ];

    BbmUsage::whereIn('tug9_number', $noTug9Array)->update([
        'bbm_type' => 'residu'
    ]);
});

Route::get('/update-ship-uuid', function(){
    set_time_limit(10000);
    $filePath = public_path('bbm_receipt.json');
    $jsonData = file_get_contents($filePath);
    $bbmReceipts = json_decode($jsonData, true); // Decode JSON menjadi array

    foreach ($bbmReceipts as $receipt) {
        $idPengiriman = $receipt['ID_PENGIRIMAN'];
        $ship = Ship::where([
            'ID_KAPAL' => $receipt['ID_KAPAL'],
        ])->first();

        // Cek apakah ID_PENGIRIMAN ada di tabel bbm_receipts
        BbmReceipt::where('ID_PENGIRIMAN', $idPengiriman)->update([
            'ship_uuid' => $ship->uuid ?? null,
        ]);
    }

    echo "okee";
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/query', 'HomeController@query')->name('query');
Route::get('/zer', 'HomeController@zer')->name('zer');
Route::get('/thn2006', 'HomeController@thn2006')->name('thn2006');
Route::get('/thn2023', 'HomeController@thn2023')->name('thn2023');
Route::get('/labor', 'HomeController@labor')->name('labor');
Route::get('/labor1', 'HomeController@labor1')->name('labor1');
Route::get('/labor2', 'HomeController@labor2')->name('labor2');
Route::get('/labor21', 'HomeController@labor21')->name('labor2');
Route::get('/labor3', 'HomeController@labor3')->name('labor3');
Route::get('/labor31', 'HomeController@labor31')->name('labor31');
Route::get('/labor4', 'HomeController@labor4')->name('labor4');
Route::get('/tug', 'HomeController@tug')->name('tug');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/scheduling-plan/create', [SchedulingPlanController::class, 'create'])->name('scheduling.create');
Route::get('/scheduling-plan/edit/{id}', [SchedulingPlanController::class, 'edit'])->name('scheduling.edit');
Route::put('/scheduling-plan/update/{id}', [SchedulingPlanController::class, 'update'])->name('scheduling.update');
Route::post('/scheduling-plan', [SchedulingPlanController::class, 'store'])->name('scheduling.store');
require 'administration.php';
require 'initial-data.php';
require 'contract.php';
require 'master-data.php';
require 'batu-bara.php';
require 'biomassa.php';
require 'input.php';
require 'report.php';
require 'setting.php';

