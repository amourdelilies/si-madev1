<?php

namespace App\Livewire\PermohonanSurat;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Auth;

class CreatePermohonanSurat extends Component
{
    use WithFileUploads;

    // Form Properti
    public $jenis_surat_id;
    public $keperluan;
    
    // File upload (sesuai screenshot formulir kamu)
    public $foto_usaha;
    public $nota_bahan;

    // 🌟 Array sakti untuk menampung data kustom dinamis (Nama Usaha, Jenis Usaha, dll)
    public $data_kustom = []; 
    public $currentSlug = '';

    /**
     * Otomatis mendeteksi saat warga memilih jenis surat di dropdown
     */
    public function updatedJenisSuratId($value)
    {
        $this->data_kustom = []; // Reset inputan kustom lama
        
        $jenisSurat = JenisSurat::find($value);
        $this->currentSlug = $jenisSurat ? $jenisSurat->slug : '';
    }

    public function kirimPermohonan()
    {
        $this->validate([
            'jenis_surat_id' => 'required',
            'keperluan' => 'required|min:5',
            'foto_usaha' => $this->currentSlug === 'surat-keterangan-usaha-sku' ? 'required|image|max:2048' : 'nullable',
            'nota_bahan' => $this->currentSlug === 'surat-keterangan-usaha-sku' ? 'required|image|max:2048' : 'nullable',
        ]);

        // Proses simpan file persyaratan warga
        $berkas = [];
        if ($this->foto_usaha) {
            $berkas['foto_usaha'] = $this->foto_usaha->store('bukti_pendukung', 'public');
        }
        if ($this->nota_bahan) {
            $berkas['nota_insidentil'] = $this->nota_bahan->store('bukti_pendukung', 'public');
        }

        // Simpan data pengajuan surat ke database
        PengajuanSurat::create([
            'penduduk_id' => Auth::user()->penduduk->id, // Mengambil relasi penduduk dari user yang login
            'jenis_surat_id' => $this->jenis_surat_id,
            'keperluan' => $this->keperluan,
            'status' => 'pending',
            'bukti_pendukung' => json_encode($berkas),
            
            // 🌟 Data kustom dinamis disimpan ke format JSON database
            'data_kustom' => json_encode($this->data_kustom), 
        ]);

        session()->flash('message', 'Permohonan surat Anda berhasil dikirim ke admin desa!');
        return redirect()->route('warga.dashboard'); 
    }

    public function render()
    {
        return view('livewire.permohonan-surat.create-permohonan-surat', [
            'daftarJenisSurat' => JenisSurat::all()
        ]);
    }
}