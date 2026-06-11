<?php

namespace App\Livewire\Penduduk;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Penduduk;
use App\Models\PengajuanSurat; // Panggil model surat yang kita buat tadi
use Livewire\Attributes\Layout;

class DashboardPenduduk extends Component
{
    // Properti Form Pengajuan Surat
    public $jenis_surat, $keperluan;

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('registrasi');
    }

    //  FUNGSI MENYIMPAN SURAT DIGITAL KE DATABASE
    public function ajukanSurat()
    {
        $this->validate([
            'jenis_surat' => 'required',
            'keperluan' => 'required|string|min:5',
        ]);

        // Cari ID penduduk fisik dari user yang sedang login
        $pendudukFisik = Penduduk::where('user_id', Auth::id())->first();

        if ($pendudukFisik) {
            PengajuanSurat::create([
                'penduduk_id' => $pendudukFisik->id,
                'jenis_surat' => $this->jenis_surat,
                'keperluan' => $this->keperluan,
                'status' => 'pending', // Status awal pengajuan selalu pending
            ]);

            // Reset input form setelah sukses dikirim
            $this->reset(['jenis_surat', 'keperluan']);

            // Tampilkan notifikasi sukses di halaman dashboard
            session()->flash('message', ' Pengajuan surat berhasil dikirim! Silakan tunggu verifikasi berkas oleh Perangkat Desa.');
        }
    }
 
    #[Layout('welcome')]
    public function render()
    {
        // 🌟 JIKA YANG MASUK ADALAH ADMIN DESA, PAKSA KELUAR AGAR TIDAK MERUSAK TAMPILAN WARGA
        if (Auth::user()->email === 'admin@gmail.com' || str_contains(Auth::user()->email, 'admin')) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('registrasi');
        }

        $dataPenduduk = Penduduk::where('user_id', Auth::id())->first();

        return view('livewire.penduduk.dashboard-penduduk', [
            'penduduk' => $dataPenduduk
        ]);
    }
}