<?php
namespace App\Livewire\Pengaduan;

use Livewire\Component;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use App\Models\Penduduk;

class RiwayatPengaduanSingkat extends Component
{
    public function render()
    {
        
        $dataPenduduk = Penduduk::where('user_id', Auth::id())->first();
        

        if ($dataPenduduk) {
            // Sesuai request: Kunci di skala industri gunakan ->take(3) untuk membatasi data di dashboard
            $semuaPengaduan = Pengaduan::where('penduduk_id', $dataPenduduk->id)
                ->latest()
                ->paginate(10);
                // ->get();
        } else {
            $semuaPengaduan = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        return view('livewire.pengaduan.riwayat-pengaduan-singkat', [
            'semuaPengaduan' => $semuaPengaduan
        ]);
    }
}