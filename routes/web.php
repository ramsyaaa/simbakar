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

