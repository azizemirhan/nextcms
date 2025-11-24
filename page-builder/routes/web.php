<?php

use App\Http\Controllers\PageBuilderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('builder.index');
});

// Page Builder Routes
Route::prefix('builder')->name('builder.')->group(function () {
    Route::get('/', [PageBuilderController::class, 'index'])->name('index');
    Route::post('/create', [PageBuilderController::class, 'create'])->name('create');
    Route::get('/editor/{page}', [PageBuilderController::class, 'editor'])->name('editor');
    Route::post('/save/{page}', [PageBuilderController::class, 'save'])->name('save');
    Route::get('/preview/{page}', [PageBuilderController::class, 'preview'])->name('preview');
    Route::get('/export/{page}', [PageBuilderController::class, 'export'])->name('export');
    Route::post('/import/{page}', [PageBuilderController::class, 'import'])->name('import');
    Route::delete('/delete/{page}', [PageBuilderController::class, 'destroy'])->name('destroy');
});

// Public page view
Route::get('/page/{slug}', function ($slug) {
    $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
    $builderService = new \App\Services\BuilderService();
    return view('builder.preview', [
        'page' => $page,
        'content' => $builderService->render($page->layout_data ?? []),
    ]);
})->name('page.show');