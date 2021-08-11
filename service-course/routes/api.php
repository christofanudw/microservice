<?php

use App\Http\Controllers\ChapterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MentorController;

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

Route::prefix('courses')->group(function(){
    Route::post('/', [CourseController::class, 'store'])->name('courses.store');
    Route::put('/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::delete('/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
});

Route::prefix('chapters')->group(function(){
    Route::post('/', [ChapterController::class, 'store'])->name('chapters.store');
    Route::put('/{id}', [ChapterController::class, 'update'])->name('chapters.update');
    Route::get('/', [ChapterController::class, 'index'])->name('chapters.index');
    Route::delete('/{id}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    Route::get('/{id}', [ChapterController::class, 'show'])->name('chapters.show');
});

Route::prefix('lessons')->group(function(){
    Route::post('/', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/{id}', [LessonController::class, 'show'])->name('lessons.show');
    Route::put('/{id}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/{id}', [LessonController::class, 'destroy'])->name('lessons.destroy');
});