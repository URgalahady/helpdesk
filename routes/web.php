<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard and protected routes
Route::middleware(['auth'])->group(function () {
    // Role-based dashboard — semua lewat DashboardController agar $stats terkirim
    Route::get('/dashboard',           [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'index'])->name('dashboard.mahasiswa');
    Route::get('/dashboard/dosen',     [DashboardController::class, 'index'])->name('dashboard.dosen');
    Route::get('/dashboard/admin',     [DashboardController::class, 'index'])->name('dashboard.admin');

    // Ticket CRUD resource (POST tickets → tickets.store, GET tickets → tickets.index, dsb)
    Route::resource('tickets', TicketController::class);

    // Form buat pengaduan khusus per role (harus sebelum resource agar tidak tertimpa)
    Route::get('tickets/create/mahasiswa', function () {
        return view('tickets.create_mahasiswa');
    })->name('tickets.create.mahasiswa');

    Route::get('tickets/create/dosen', function () {
        return view('tickets.create_dosen');
    })->name('tickets.create.dosen');

    // Profile routes
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
