<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerzuimControlController;
use App\Http\Controllers\BeheerderController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::view('/', 'welcome');

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Alles onder de dashboard route is alleen toegankelijk voor admins
Route::middleware(['auth', 'verified', 'is_admin'])->group(function () {
    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Beheerder routes
    Route::resource('beheerder', BeheerderController::class)->only(['index', 'create', 'store']);
    Route::post('/beheerder/mark-not-sick', [BeheerderController::class, 'markNotSick'])->name('beheerder.markNotSick');

    // VerzuimControle routes
    Route::prefix('medical-checks')->name('medical-checks.')->group(function () {
        Route::post('/', [VerzuimControlController::class, 'store'])->name('store');
        Route::post('{medicalCheck}/approve', [VerzuimControlController::class, 'approve'])->name('approve');
        Route::post('{medicalCheck}/disapprove', [VerzuimControlController::class, 'disapprove'])->name('disapprove');
        Route::get('data', [VerzuimControlController::class, 'getMedicalChecks'])->name('data');
    });

    Route::get('/beheerder/index', [VerzuimControlController::class, 'index'])->name('beheerder.index');
});
require __DIR__.'/auth.php';
