<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PDFGenController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckValidSession;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return redirect('/create');
});

Route::get('/create', InvoiceController::class)->name('create');
Route::post('/getpdf', [PDFGenController::class, 'export'])->name('export');

Route::middleware(CheckValidSession::class)->group(function () {
    Route::get('/preview', [PDFGenController::class, 'preview'])->name('preview')->middleware(CheckValidSession::class);

    Route::get('/download',
        [PDFGenController::class, 'download'])->name('download')->middleware(CheckValidSession::class);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('profile')->as('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';

/*
 -Notes Section
 -Landing page
 - project cleanup
 * */
