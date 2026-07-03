<?php

namespace App\Livewire\Penduduk;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\Pengaduan; 
use App\Models\BantuanLumbungDesa; // Pastikan model ini di-import
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads; 

class DashboardPenduduk extends Component
{
    use WithFileUploads;

    // Properti Layanan Surat
    public $jenis_surat, $keperluan;
    public $bukti_pendukung = []; 
    public $activeTab = 'profil'; 

    // Properti Donasi Lumbung Desa (Swadaya Warga)
    public $nama_donasi, $jumlah_donasi, $keterangan_donasi;
    public $foto_donasi; 

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->email === 'admin@gmail.com' || str_contains(Auth::user()->email, 'admin')) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('registrasi');
        }
    }

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
            $jenisSuratId = match ($this->jenis_surat) {
                'Surat Keterangan Domisili'            => 1,
                'Surat Keterangan Usaha (SKU)'         => 2,
                'Surat Keterangan Tidak Mampu (SKTM)'  => 3,
                'Surat Keterangan Kelakuan Baik'       => 4,
                default                                => 1,
            };

            $uploadedPaths = [];
            foreach ($this->bukti_pendukung as $key => $file) {
                if ($file) {
                    $extension = $file->getClientOriginalExtension();
                    $namaBersih = str_replace(' ', '_', $pendudukFisik->nama_lengkap);
                    $filename = $namaBersih . '-' . $key . '-' . time() . '.' . $extension;
                    $uploadedPaths[$key] = $file->storeAs('bukti_surat', $filename, 'public');
                }
            }

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
            session()->flash('message', 'Pengajuan surat berhasil dikirim! Silakan tunggu verifikasi berkas oleh Perangkat Desa.');
        }
    }

    /**
     * 🟢 FITUR BARU: Proses Rencana Donasi Hasil Panen/Bumi dari Warga
     */
    public function donasikanBarang()
    {
        $this->validate([
            'nama_donasi' => 'required|string|min:3',
            'jumlah_donasi' => 'required|integer|min:1',
            'keterangan_donasi' => 'nullable|string',
            'foto_donasi' => 'required|image|max:2048', 
        ]);

        $pendudukFisik = Penduduk::where('user_id', Auth::id())->first();

        if ($pendudukFisik) {
            // Beri nama file unik untuk foto barang donasi
            $filename = 'donasi_' . time() . '.' . $this->foto_donasi->getClientOriginalExtension();
            $pathFoto = $this->foto_donasi->storeAs('dokumentasi-lumbung/warga', $filename, 'public');

            // Simpan rencana donasi masuk dengan status 'pending' dan sumber_input 'warga'
            BantuanLumbungDesa::create([
                'penduduk_id' => $pendudukFisik->id,
                'nama_barang' => $this->nama_donasi,
                'jumlah_bantuan' => $this->jumlah_donasi,
                'sumber_bantuan' => 'Swadaya / CSR / Sumbangan', 
                'alasan_keperluan' => $this->keterangan_donasi, 
                'status' => 'pending', 
                'sumber_input' => 'warga', 
                'foto_penerimaan_warga' => $pathFoto, 
                'disalurkan_pada' => now(),
            ]);

            $this->reset(['nama_donasi', 'jumlah_donasi', 'keterangan_donasi', 'foto_donasi']);
            session()->flash('message_lumbung', 'Rencana donasi berhasil dikirim! Silakan bawa hasil bumi Anda ke Lumbung Desa untuk diverifikasi dan ditimbang petugas.');
        }
    }
 
    #[Layout('welcome')]
    public function render()
    {
        $dataPenduduk = Penduduk::where('user_id', Auth::id())->first();
       
        $daftarPengaduan = $dataPenduduk 
            ? Pengaduan::where('penduduk_id', $dataPenduduk->id)->latest()->take(3)->get()
            : collect();

        $riwayatSurat = $dataPenduduk 
            ? PengajuanSurat::where('penduduk_id', $dataPenduduk->id)->latest()->get() 
            : collect();

        // 1. Ambil data riwayat kontribusi donasi yang dikirim oleh warga ini
        $riwayatDonasi = $dataPenduduk 
            ? BantuanLumbungDesa::where('penduduk_id', $dataPenduduk->id)->where('sumber_input', 'warga')->latest()->get()
            : collect();

        // 🟢 2. TAMBAHKAN INI: Ambil riwayat bantuan yang DITERIMA warga dari admin desa
        $riwayatPenerimaan = $dataPenduduk
            ? BantuanLumbungDesa::where('penduduk_id', $dataPenduduk->id)
                ->where('sumber_input', '!=', 'warga') // mengambil inputan admin
                ->where('status', 'disalurkan') // hanya yang sudah resmi disalurkan
                ->latest()
                ->get()
            : collect();

        return view('livewire.penduduk.dashboard-penduduk', [
            'penduduk' => $dataPenduduk,
            'riwayatSurat' => $riwayatSurat,
            'daftarPengaduan' => $daftarPengaduan,
            'riwayatDonasi' => $riwayatDonasi, 
            'riwayatPenerimaan' => $riwayatPenerimaan, // 🟢 Oper ke blade
        ]);
    }
}