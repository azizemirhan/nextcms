<?php

use App\Http\Controllers\PageBuilderController;
use Illuminate\Support\Facades\Route;

// Page Builder API Routes
Route::prefix('builder')->group(function () {
    Route::get('/pages/{id}', [PageBuilderController::class, 'show']);
    Route::post('/pages', [PageBuilderController::class, 'store']);
    Route::put('/pages/{id}', [PageBuilderController::class, 'update']);
    Route::delete('/pages/{id}', [PageBuilderController::class, 'destroy']);
});
