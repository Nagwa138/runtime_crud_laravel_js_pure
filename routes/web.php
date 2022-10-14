<?php

use App\Http\Controllers\FirstSectionController;
use App\Http\Controllers\SecondSectionController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::resource('first_sections', FirstSectionController::class);
Route::resource('second_sections', SecondSectionController::class);
