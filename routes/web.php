<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Scheduling\SchedulingPlanController;

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
Route::get('/query', 'HomeController@query')->name('query');
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

