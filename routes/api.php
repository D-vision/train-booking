<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware'=>'auth'],function (){
    Route::get('/user', function (Request $request) {
        return \App\Http\Resources\UserResource::make($request->user());
    });

    Route::get('tickets',[TicketController::class,'tickets']);
    Route::get('cities',[TicketController::class,'cities']);
    Route::get('search',[TicketController::class,'search']);
    Route::post('order',[TicketController::class,'order']);

});

