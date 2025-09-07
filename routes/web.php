<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->is_admin) { 
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard'); 
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('documents.index');
})->middleware(['auth', 'verified'])->name('dashboard');

//  User profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//  Admin-only routes 
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDocumentController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/documents', [AdminDocumentController::class, 'index'])->name('admin.documents');

    Route::post('/admin/documents/{id}/approve', [AdminDocumentController::class, 'approve'])->name('admin.documents.approve');
    Route::post('/admin/documents/{id}/reject', [AdminDocumentController::class, 'reject'])->name('admin.documents.reject');
    Route::get('/documents/{id}/download', [DocumentController::class, 'download'])->name('documents.download');

});

// Document routes for normal users
Route::middleware('auth')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/upload', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents/upload', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
});

Route::get('/documents/logs', [DocumentController::class, 'logs'])->name('documents.logs');

Route::get('/documents/{id}/download', [DocumentController::class, 'download'])
    ->name('documents.download');
require __DIR__.'/auth.php';
