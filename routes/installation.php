<?php

use Illuminate\Support\Facades\Route;

Route::get('/installation', function () {return inertia('Installation'); });

Route::prefix('sync')->group(function(){
    Route::get('/check', [App\Http\Controllers\SyncController::class, 'checkApi']);
    Route::get('/counts', [App\Http\Controllers\SyncController::class, 'fetchCount']);
    Route::get('/lists', [App\Http\Controllers\SyncController::class, 'lists']);
    Route::get('/locations', [App\Http\Controllers\SyncController::class, 'locations']);
    Route::get('/schools', [App\Http\Controllers\SyncController::class, 'schools']);
});