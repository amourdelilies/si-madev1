<?php

namespace App\Livewire\Penduduk;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads; 

class DashboardPenduduk extends Component
{
    use WithFileUploads;

    public $jenis_surat, $keperluan;
    public $bukti_pendukung = []; 
    public $activeTab = 'profil'; 

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('registrasi');
    }

    public function updatedJenisSurat()
    {
        $this->bukti_pendukung = [];
    }

    public function ajukanSurat()
    {
        // 1. Tentukan aturan validasi dinamis berdasarkan jenis surat
        $rules = [
            'jenis_surat' => 'required',
            'keperluan' => 'required|string|min:5',
        ];

        if ($this->jenis_surat === 'Surat Keterangan Domisili') {
            $rules['bukti_pendukung.pengantar_rt'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        } elseif ($this->jenis_surat === 'Surat Keterangan Usaha (SKU)') {
            $rules['bukti_pendukung.foto_usaha'] = 'required|file|mimes:jpg,jpeg,png|max:2048';
            $rules['bukti_pendukung.nota_insidentil'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        } elseif ($this->jenis_surat === 'Surat Keterangan Tidak Mampu (SKTM)') {
            $rules['bukti_pendukung.pengantar_rt'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $rules['bukti_pendukung.foto_rumah'] = 'required|file|mimes:jpg,jpeg,png|max:2048';
        } elseif ($this->jenis_surat === 'Surat Keterangan Kelakuan Baik') {
            $rules['bukti_pendukung.rekomendasi_banjar'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $this->validate($rules);

        $pendudukFisik = Penduduk::where('user_id', Auth::id())->first();

        if ($pendudukFisik) {
            
            // 🟢 SOLUSI PAKEM: Kunci mati penentuan ID agar sinkron dengan Filament & anti-error 1452
            $jenisSuratId = match ($this->jenis_surat) {
                'Surat Keterangan Domisili'            => 1,
                'Surat Keterangan Usaha (SKU)'         => 2,
                'Surat Keterangan Tidak Mampu (SKTM)'  => 3,
                'Surat Keterangan Kelakuan Baik'       => 4,
                default                                => 1,
            };

            // 2. Proses upload semua file yang ada di dalam array bukti_pendukung
            $uploadedPaths = [];
            foreach ($this->bukti_pendukung as $key => $file) {
                if ($file) {
                    // Ambil ekstensi asli berkas (misal: jpg, png, pdf)
                    $extension = $file->getClientOriginalExtension();
                    
                    // Bersihkan nama warga dari spasi agar aman untuk nama file di URL/Storage
                    $namaBersih = str_replace(' ', '_', $pendudukFisik->nama_lengkap);
                    
                    // Buat format nama file: NamaWarga-JenisBerkas-Waktu.ekstensi
                    $filename = $namaBersih . '-' . $key . '-' . time() . '.' . $extension;
                    
                    // Simpan menggunakan storeAs dengan nama file custom rapi
                    $uploadedPaths[$key] = $file->storeAs('bukti_surat', $filename, 'public');
                }
            }

            // 3. Simpan ke database dengan jenis_surat_id yang sudah dikunci pas
            PengajuanSurat::create([
                'penduduk_id'      => $pendudukFisik->id,
                'jenis_surat'      => $this->jenis_surat,
                'alasan_pengajuan' => $this->keperluan, 
                'jenis_surat_id'   => $jenisSuratId, 
                'keperluan'        => $this->keperluan, 
                'status'           => 'pending',
                'bukti_pendukung'  => json_encode($uploadedPaths), 
            ]);

            $this->reset(['jenis_surat', 'keperluan', 'bukti_pendukung']);

            session()->flash('message', 'Pengajuan surat beserta dokumen persyaratan berhasil dikirim!');
        }
    }
 
    #[Layout('welcome')]
    public function render()
    {
        if (Auth::user()->email === 'admin@gmail.com' || str_contains(Auth::user()->email, 'admin')) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('registrasi');
        }

        $dataPenduduk = Penduduk::where('user_id', Auth::id())->first();

        $riwayatSurat = $dataPenduduk 
            ? PengajuanSurat::where('penduduk_id', $dataPenduduk->id)->latest()->get() 
            : collect();

        return view('livewire.penduduk.dashboard-penduduk', [
            'penduduk' => $dataPenduduk,
            'riwayatSurat' => $riwayatSurat
        ]);
    }
}