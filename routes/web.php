<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrasiPenduduk; 
use App\Livewire\Auth\LoginPenduduk; 
//  PASTIKAN: Jalur impor ini benar-benar mengarah ke folder Penduduk!
use App\Livewire\Penduduk\DashboardPenduduk;
use App\Livewire\Pengaduan\CreatePengaduan;  
use App\Livewire\Pengaduan\RiwayatPengaduan;   
use App\Livewire\Pengaduan\DetailPengaduan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registrasi', RegistrasiPenduduk::class)->name('registrasi');

// Route::get('/login', function () {
//     return redirect()->route('registrasi');
// })->name('login');
Route::get('/login', LoginPenduduk::class)->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/pengaduan/create', CreatePengaduan::class)->name('pengaduan.buat');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/pengaduan/riwayat', RiwayatPengaduan::class)->name('pengaduan.riwayat');
});
Route::middleware(['auth'])->group(function () {
    // Rute detail dinamis memanfaatkan ID Pengaduan
    Route::get('/pengaduan/riwayat/{id}', DetailPengaduan::class)->name('pengaduan.detail');
});

Route::get('/warga/dashboard', DashboardPenduduk::class)
    ->middleware('auth')
    ->name('penduduk.dashboard');