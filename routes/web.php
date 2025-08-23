<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


use App\Http\Controllers\CertificatePreviewController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

    session(['locale' => $locale]);
    return back();
})->name('lang.switch');


require __DIR__.'/auth.php';




Route::get('/certificate-preview', [CertificatePreviewController::class, 'form'])->name('certificate.preview.form');
Route::post('/certificate-preview', [CertificatePreviewController::class, 'generate'])->name('certificate.preview.generate');




Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::get('forgot-password', [AdminAuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('password.email');




 
});

Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');