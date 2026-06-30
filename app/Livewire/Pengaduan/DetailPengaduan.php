<?php
namespace App\Livewire\Pengaduan;

use Livewire\Component;
use App\Models\Pengaduan;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class DetailPengaduan extends Component
{
    public $pengaduan;

    #[Layout('welcome')]
    public function mount($id)
    {
        // 1. Ambil data penduduk yang login
        $dataPenduduk = Penduduk::where('user_id', Auth::id())->first();

        if (!$dataPenduduk) {
            abort(403, 'Akses ditolak. Profil Anda belum terhubung.');
        }

        // 2. Cari pengaduan berdasarkan ID DAN pastikan milik penduduk bersangkutan
        $this->pengaduan = Pengaduan::where('id', $id)
            ->where('penduduk_id', $dataPenduduk->id)
            ->firstOrFail(); // Otomatis return 404 jika iseng ganti ID di URL
    }

    public function render()
    {
        return view('livewire.pengaduan.detail-pengaduan');
    }
}