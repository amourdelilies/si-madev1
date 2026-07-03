<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout; // 🌟 Memastikan layout ter-import dengan benar
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Penduduk;

class LoginPenduduk extends Component
{
    // Properti Form Login sesuai kebiasaan input warga
    public $nik, $no_kk;

    // Aturan Validasi Input 16 Digit khas NIK dan KK di Indonesia
    protected $rules = [
        'nik' => 'required|digits:16',
        'no_kk' => 'required|digits:16',
    ];

    /**
     * Fitur pengujian instan untuk mempercepat proses simulasi/demo di depan dosen.
     */
    public function isiDataOtomatis()
    {
        $this->nik = '5102021708997062'; 
        $this->no_kk = '5102021504090015';
    }

    /**
     * Logika Autentikasi Menggunakan Email Tiruan Berbasis NIK
     */
    public function login()
    {
        $this->validate();

        // Rekonstruksi email tiruan sesuai format saat warga melakukan registrasi
        $emailTiruan = $this->nik . '@simade.id';
        
        // Coba lakukan autentikasi ke tabel users
        if (Auth::attempt(['email' => $emailTiruan, 'password' => $this->no_kk])) {
            
            // Cari data fisik penduduk untuk memeriksa status verifikasinya
            $penduduk = Penduduk::where('user_id', Auth::id())->first();
            
            // 🌟 PROTEKSI SISTEM: Jika akun belum di-ACC/diaktifkan admin (is_aktif = 0)
            if ($penduduk && !$penduduk->is_aktif) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                session()->flash('error', 'Akun Anda belum aktif. Silakan tunggu verifikasi berkas oleh Perangkat Desa.');
                return;
            }

            // Jika aktif, amankan session cookie warga
            session()->regenerate();

            // Alihkan langsung ke dashboard penduduk mandiri tanpa tambahan method chaining
            return redirect()->route('penduduk.dashboard');
        }

        // Tampilkan pesan jika kombinasi NIK/KK salah atau tidak terdaftar
        session()->flash('error', 'NIK atau Nomor KK yang Anda masukkan tidak sesuai.');
    }

    /**
     * Render view template login dengan layout pembungkus 'welcome'
     */
    #[Layout('welcome')] // 🟢 Deklarasi layout tunggal yang sah di Livewire v3
    public function render()
    {
        // Murni return view tanpa embel-embel ->layout() di bawahnya
        return view('livewire.auth.login-penduduk');
    }
}