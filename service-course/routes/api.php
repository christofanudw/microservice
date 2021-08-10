<?php

use App\Http\Controllers\MentorController;
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

Route::prefix('mentors')->group(function(){
    Route::post('/', [MentorController::class, 'store'])->name('mentors.store');
    Route::put('/{id}', [MentorController::class, 'update'])->name('mentors.update');
    Route::get('/', [MentorController::class, 'index'])->name('mentors.index');
    Route::get('/{id}', [MentorController::class, 'show'])->name('mentors.show');
    Route::delete('/{id}', [MentorController::class, 'destroy'])->name('mentors.destroy');
});