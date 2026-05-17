<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WargaAuthController;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// RUTE WARGA
// ==========================================
Route::get('/masuk', [WargaAuthController::class, 'showLogin'])->name('warga.login');
Route::post('/masuk', [WargaAuthController::class, 'login'])->name('warga.login.submit');

// Rute Warga (Wajib Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/lapor', [PublicController::class, 'showFormLapor'])->name('lapor.web');
    Route::post('/lapor', [PublicController::class, 'storeLapor'])->name('lapor.web.store');
    Route::get('/dashboard-warga', [PublicController::class, 'dashboardWarga'])->name('warga.dashboard');
    
    // Logout untuk semua user (Warga maupun Admin bisa pakai ini)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ==========================================
// RUTE ADMIN
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// PERBAIKAN: Gunakan AuthController milik admin, bukan WargaAuthController
Route::post('/login', [AuthController::class, 'login']); 

// Rute khusus Admin (Wajib Login & Role Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('admin.laporan.show');
    Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('admin.laporan.update');
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('admin.setting.index');
    Route::post('/pengaturan', [SettingController::class, 'update'])->name('admin.setting.update');
});