<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeheerderController;
use App\Http\Middleware\IsAdmin;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('beheerder', BeheerderController::class)
        ->only(['index', 'create', 'store']);
});

Route::post('/beheerder', [BeheerderController::class, 'store'])->name('beheerder.store');
Route::post('/beheerder/mark-not-sick', [BeheerderController::class, 'markNotSick'])->name('beheerder.markNotSick');


require __DIR__.'/auth.php';
