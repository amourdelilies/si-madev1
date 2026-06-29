<?php
namespace App\Livewire\Pengaduan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengaduan;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class RiwayatPengaduan extends Component
{
    use WithPagination; // Best practice industri: gunakan trait pagination

    #[Layout('welcome')] // Otomatis menggunakan layout welcome tanpa header bar atas sesuai preferensimu
    public function render()
    {
        $dataPenduduk = Penduduk::where('user_id', Auth::id())->first();
        
        $semuaPengaduan = collect();

        if ($dataPenduduk) {
            // Mengambil SEMUA data menggunakan paginate, bukan get() biasa
            $semuaPengaduan = Pengaduan::where('penduduk_id', $dataPenduduk->id)
                ->latest()
                ->paginate(10); // Menampilkan 10 data per halaman
        }

        return view('livewire.pengaduan.riwayat-pengaduan', [
            'semuaPengaduan' => $semuaPengaduan
        ]);
    }
}