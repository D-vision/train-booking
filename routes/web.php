<?php

use App\Http\Controllers\UserController;
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

Route::view('/','home')->name('app')->middleware(['auth']);
Route::view('login','login')->name('login')->middleware(['guest']);
Route::view('register','register')->name('register')->middleware(['guest']);


Route::post('login',[UserController::class,'login'])->middleware(['throttle:login']);
Route::post('register',[UserController::class,'register']);

Route::post('logout',[UserController::class,'logout'])
    ->middleware(['auth'])
    ->name('logout');
