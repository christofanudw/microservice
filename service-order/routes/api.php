<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhookController;

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

Route::prefix('orders')->group(function(){
    Route::post('/', [OrderController::class, 'create'])->name('order.create');
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
});

Route::prefix('webhook')->group(function(){
    Route::post('/', [WebhookController::class, 'midtransHandler']);
});
