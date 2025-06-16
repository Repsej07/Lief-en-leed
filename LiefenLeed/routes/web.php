<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ImportController;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search-employees', [EmployeeController::class, 'search']);

Route::post('/aanvraag', [DashboardController::class, 'storeRequest'])->name('storeRequest');

    // Alles onder de dashboard route is alleen toegankelijk voor admins
Route::middleware(['auth', 'verified', 'is_admin'])->group(function () {
    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Request routes alleen voor admins bereikbaar
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('request/index', [RequestController::class, 'index'])->name('request.index');
    Route::post('request/{id}/goedkeuren', [RequestController::class, 'goedkeuren'])->name('request.goedkeuren');
    Route::post('request/{id}/afkeuren', [RequestController::class, 'afkeuren'])->name('request.afkeuren');
    Route::post('request/{id}/toggle', [RequestController::class, 'toggle'])->name('request.toggleStatus');
    Route::view('/import', 'components.import')->name('import');
    Route::post('/import-data', [ImportController::class, 'import'])->name('import.data');

});
});
require __DIR__.'/auth.php';
