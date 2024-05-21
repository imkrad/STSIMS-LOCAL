<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);
Route::get('/', function () {return inertia('Welcome'); });
Route::get('/verification/{code}', [App\Http\Controllers\WelcomeController::class, 'verification']);

Route::middleware(['2fa','auth','verified'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/insights', [App\Http\Controllers\InsightController::class, 'index']);
    Route::resource('/profile', App\Http\Controllers\User\ProfileController::class);

    Route::resource('/schools', App\Http\Controllers\SchoolController::class);
    
    Route::prefix('scholars')->group(function(){
        Route::resource('/lists', App\Http\Controllers\Scholar\ListController::class);
        Route::resource('/qualifiers', App\Http\Controllers\Scholar\QualifierController::class);
        Route::resource('/endorsements', App\Http\Controllers\Scholar\EndorsementController::class);
        Route::resource('/transferees', App\Http\Controllers\Scholar\TransfereeController::class);
    });  
});

require __DIR__.'/auth.php';
require __DIR__.'/utility.php';
require __DIR__.'/installation.php';
