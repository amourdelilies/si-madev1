<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrasiPenduduk; 
//  PASTIKAN: Jalur impor ini benar-benar mengarah ke folder Penduduk!
use App\Livewire\Penduduk\DashboardPenduduk; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registrasi', RegistrasiPenduduk::class)->name('registrasi');

Route::get('/login', function () {
    return redirect()->route('registrasi');
})->name('login');

// PERBAIKAN: Ubah URL menjadi /warga/dashboard agar tidak bentrok dengan panel admin
Route::get('/warga/dashboard', DashboardPenduduk::class)
    ->middleware('auth')
    ->name('penduduk.dashboard');