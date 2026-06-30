<?php
namespace App\Livewire\Pengaduan;

use Livewire\Component;
// use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Pengaduan;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Auth;

class CreatePengaduan extends Component
{
    // use WithFileUploads;

    public $judul_pengaduan;
    public $kategori;
    public $deskripsi_pengaduan;
    // public $foto;

    protected $rules = [
        'judul_pengaduan' => 'required|min:8|max:150',
        'kategori' => 'required',
        'deskripsi_pengaduan' => 'required|min:15',
        // 'foto' => 'nullable|image|max:2048',
    ];

    public function simpanPengaduan()
    {
        $this->validate();

        $penduduk = Penduduk::where('user_id', Auth::id())->first();
        if (!$penduduk) {
            session()->flash('error', 'Akun Admin tidak dapat membuat pengaduan. Silakan login sebagai warga.');
            return;
        }

        // $namaFoto = null;
        // if ($this->foto) {
        //     // Menyimpan foto ke folder storage/app/public/pengaduan
        //     $namaFoto = $this->foto->store('pengaduan', 'public');
        // }
        Pengaduan::create([
            'penduduk_id' => $penduduk->id, 
            'judul_pengaduan' => $this->judul_pengaduan,
            'kategori' => $this->kategori,
            'deskripsi_pengaduan' => $this->deskripsi_pengaduan,
            // 'foto' => $namaFoto,
            'status' => 'dikirim',
        ]);

        session()->flash('success', 'Pengaduan Anda berhasil dikirim dan sedang menunggu verifikasi.');
        $this->reset(['judul_pengaduan', 'kategori', 'deskripsi_pengaduan']);
        // $this->reset(['judul_pengaduan', 'kategori', 'isi', 'foto']);
        return redirect()->to('warga/dashboard');
    }

    #[Layout('welcome')]
    public function render()
    {
        return view('livewire.pengaduan.create-pengaduan'
        );  
    }
}