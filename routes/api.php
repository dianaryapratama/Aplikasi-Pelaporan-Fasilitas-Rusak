<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LaporanApiController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/setting/polygon', [\App\Http\Controllers\Api\LaporanApiController::class, 'getPolygon']);
// Route yang wajib menggunakan Token (Login dulu)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rute Aplikasi Flutter
    Route::post('/lapor', [LaporanApiController::class, 'store']); // Kirim laporan baru
    Route::get('/laporan/riwayat', [LaporanApiController::class, 'riwayat']); // Lihat laporan saya
    Route::post('/laporan/{id}/up', [LaporanApiController::class, 'upLaporan']); // Tombol Up
    Route::post('/update-profile', [\App\Http\Controllers\Api\AuthController::class, 'updateProfile']);
    Route::post('/user/update', [AuthController::class, 'updateProfile']);
    

});