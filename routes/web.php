<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpedisiController;
use App\Http\Controllers\PaketinController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\TowerController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('paket')->group(function () {
        Route::get('/masuk/create', [PaketinController::class, 'create'])->name('paket-masuk.create');
        Route::post('/masuk', [PaketinController::class, 'store'])->name('paket-masuk.store');

        Route::get('/lihat', [PaketinController::class, 'index'])->name('lihat-paket.index');

        Route::get('/{id}', [PaketinController::class, 'show'])->name('paket.show');
        Route::get('/{id}/edit', [PaketinController::class, 'edit'])->name('paket.edit');
        Route::put('/{id}', [PaketinController::class, 'update'])->name('paket.update');
    });

    Route::prefix('expedisi')->group(function () {
        Route::get('/', [ExpedisiController::class, 'index'])->name('expedisi.index');
        Route::post('/', [ExpedisiController::class, 'store'])->name('expedisi.store');
        Route::put('/{id}', [ExpedisiController::class, 'update'])->name('expedisi.update');
        Route::delete('/{id}', [ExpedisiController::class, 'destroy'])->name('expedisi.destroy');
    });

    Route::prefix('penghuni')->group(function () {
        Route::get('/', [PenghuniController::class, 'index'])->name('penghuni.index');
        Route::post('/', [PenghuniController::class, 'store'])->name('penghuni.store');
        Route::put('/{id}', [PenghuniController::class, 'update'])->name('penghuni.update');
        Route::delete('/{id}', [PenghuniController::class, 'destroy'])->name('penghuni.destroy');
    });

    Route::prefix('tower')->group(function () {
        Route::get('/', [TowerController::class, 'index'])->name('tower.index');
        Route::post('/', [TowerController::class, 'store'])->name('tower.store');
        Route::put('/{id}', [TowerController::class, 'update'])->name('tower.update');
        Route::delete('/{id}', [TowerController::class, 'destroy'])->name('tower.destroy');
    });

    Route::prefix('reception')->group(function () {
        Route::get('/', [ReceptionController::class, 'index'])->name('reception.index');
        Route::post('/', [ReceptionController::class, 'store'])->name('reception.store');
        Route::put('/{id}', [ReceptionController::class, 'update'])->name('reception.update');
        Route::delete('/{id}', [ReceptionController::class, 'destroy'])->name('reception.destroy');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';