<?php

use App\Http\Controllers\Api\LocationController;    
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataflowController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DataflowController::class, 'landing_page'])->name('landing-page');

Route::get('/login', [DataflowController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');



Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DataflowController::class, 'dashboard'])->name('dashboard');
    Route::get('/beranda-petugas', [DataflowController::class, 'beranda_petugas'])->name('beranda_petugas');
    
    Route::post('/api/location', [LocationController::class, 'store']);
    Route::get('/api/latest-locations', [LocationController::class, 'latest']);

    Route::post('/tracking/start', [LocationController::class, 'start']);
    Route::post('/tracking/stop', [LocationController::class, 'stop']);

    Route::get('/api/history-locations', [LocationController::class,'historyData']);

    Route::get('/export-history', [LocationController::class,'exportHistory']);
});
