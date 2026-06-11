<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Penduduk;

class LoginPenduduk extends Component
{
    // Properti Form Login sesuai kebiasaan input warga
    public $nik, $no_kk;

    protected $rules = [
        'nik' => 'required|digits:16',
        'no_kk' => 'required|digits:16',
    ];

    public function isiDataOtomatis()
    {
        $this->nik = '5102021708997062'; 
        $this->no_kk = '5102021504090015';
    }

    public function login()
    {
        $this->validate();

       
        $emailTiruan = $this->nik . '@simade.id';
        if (Auth::attempt(['email' => $emailTiruan, 'password' => $this->no_kk])) {
            
           
            $penduduk = Penduduk::where('user_id', Auth::id())->first();
            if ($penduduk && !$penduduk->is_aktif) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                session()->flash('error', 'Akun Anda belum aktif. Silakan tunggu verifikasi berkas oleh Perangkat Desa.');
                return;
            }

            session()->regenerate();

            return redirect()->route('penduduk.dashboard');
        }

        session()->flash('error', 'NIK atau Nomor KK yang Anda masukkan tidak sesuai.');
    }


    #[Layout('welcome')]
    public function render()
    {
        return view('livewire.auth.login-penduduk');
    }
}