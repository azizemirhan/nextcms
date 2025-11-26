<?php

use App\Http\Controllers\PageBuilderController;
use Illuminate\Support\Facades\Route;

// Page Builder API Routes
Route::prefix('builder')->group(function () {
    Route::get('/pages', [PageBuilderController::class, 'indexApi']);
    Route::get('/pages/{id}', [PageBuilderController::class, 'show']);
    Route::post('/pages', [PageBuilderController::class, 'store']);
    Route::put('/pages/{id}', [PageBuilderController::class, 'update']);
    Route::delete('/pages/{id}', [PageBuilderController::class, 'destroy']);

    // Global Settings
    Route::get('/global-settings', [PageBuilderController::class, 'getGlobalSettings']);
    Route::put('/global-settings', [PageBuilderController::class, 'updateGlobalSettings']);
    Route::get('/google-fonts', [PageBuilderController::class, 'getGoogleFonts']);
});
