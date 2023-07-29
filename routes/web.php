<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PDFGenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',function (){
    return redirect('/create');
});

Route::get('/create',[InvoiceController::class,'create'])->name('create');
Route::post('/getpdf', [PDFGenController::class,'export'])->name('export');

Route::get('/preview', [PDFGenController::class,'preview'])->name('preview');

Route::get('/download', [PDFGenController::class,'download'])->name('download');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
 -Validation (both ends)
 -Notes Section
 -Landing page
 - protect download route with session key
 - project cleanup
 * */
