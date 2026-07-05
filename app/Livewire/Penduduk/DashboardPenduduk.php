<?php

namespace App\Livewire\Penduduk;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\Pengaduan; 
use App\Models\BantuanLumbungDesa;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads; 

class DashboardPenduduk extends Component
{
    use WithFileUploads;

    // Properti Layanan Surat
    public $jenis_surat, $keperluan;
    public $bukti_pendukung = []; 
    public $activeTab = 'profil'; 
    public $data_kustom = [];
    public $dynamicFormFields = [];
    public $dynamicUploadFields = [];

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

    public function updatedJenisSurat($value)
    {
        $this->bukti_pendukung = [];
        $this->data_kustom = [];
        $this->dynamicFormFields = [];
        $this->dynamicUploadFields = [];

        // 🌟 PEMETAAN LENGKAP 8 PERSYARATAN DAN INPUT FORM DINAMIS SCALABLE
        $konfigurasiSurat = [
            'Surat Keterangan Usaha (SKU)' => [
                'form' => [
                    ['name' => 'nama_usaha', 'label' => 'Nama Usaha', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Toko Melati'],
                    ['name' => 'jenis_usaha', 'label' => 'Jenis Usaha / Sektor', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Sembako / Kuliner'],
                    ['name' => 'lama_usaha', 'label' => 'Tanggal Mulai Usaha', 'type' => 'date', 'required' => true, 'placeholder' => 'Contoh: 3 Tahun / Sejak 2023'],
                    ['name' => 'alamat_usaha', 'label' => 'Alamat Lengkap Tempat Usaha', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Banjar Dinas Semeton'],
                ],
                'upload' => [
                    ['name' => 'foto_usaha', 'label' => 'Foto Fisik Tempat Usaha', 'required' => true, 'accept' => '.jpg,.jpeg,.png', 'max' => '2MB'],
                    ['name' => 'pengantar_rt', 'label' => 'Surat Pengantar RT/Banjar', 'required' => false, 'accept' => '.jpg,.jpeg,.png,.pdf', 'max' => '2MB'],
                ]
            ],
            'Surat Keterangan Tidak Mampu (SKTM)' => [
                'form' => [
                    ['name' => 'peruntukan_sktm', 'label' => 'Peruntukan SKTM', 'type' => 'select', 'required' => true, 'options' => ['Beasiswa Pendidikan', 'BPJS Kesehatan', 'Bantuan Sosial']],
                ],
                'upload' => [
                    ['name' => 'pengantar_rt', 'label' => 'Surat Pengantar RT/Banjar', 'required' => true, 'accept' => '.jpg,.jpeg,.png,.pdf', 'max' => '2MB'],
                    ['name' => 'foto_rumah', 'label' => 'Foto Rumah Tinggal (Tampak Depan)', 'required' => false, 'accept' => '.jpg,.jpeg,.png', 'max' => '2MB'],
                ]
            ],
            'Surat Keterangan Domisili' => [
                'form' => [
                    ['name' => 'alamat_domisili_sekarang', 'label' => 'Alamat Domisili Sekarang', 'type' => 'text', 'required' => true, 'placeholder' => 'Alamat lengkap tempat tinggal sekarang'],
                    ['name' => 'lama_tinggal', 'label' => 'Lama Tinggal', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: 1 Tahun / 6 Bulan'],
                ],
                'upload' => [
                    ['name' => 'bukti_tinggal', 'label' => 'Bukti Tempat Tinggal (Sewa/Kos/Sertifikat)', 'required' => true, 'accept' => '.jpg,.jpeg,.png,.pdf', 'max' => '2MB'],
                    ['name' => 'pengantar_rt', 'label' => 'Surat Pengantar RT/Banjar', 'required' => true, 'accept' => '.jpg,.jpeg,.png,.pdf', 'max' => '2MB'],
                ]
            ],
            'Surat Pengantar SKCK' => [
                'form' => [
                    ['name' => 'peruntukan_skck', 'label' => 'Keperluan SKCK', 'type' => 'select', 'required' => true, 'options' => ['Melamar Pekerjaan Swasta', 'Pendaftaran CPNS / BUMN', 'Melanjutkan Pendidikan', 'Lainnya']],
                ],
                'upload' => [
                    ['name' => 'pas_foto', 'label' => 'Pas Foto Berwarna Terbaru (4x6)', 'required' => true, 'accept' => '.jpg,.jpeg,.png', 'max' => '2MB'],
                ]
            ],
            'Surat Pindah' => [
                'form' => [
                    ['name' => 'alamat_asal', 'label' => 'Alamat Asal Lengkap', 'type' => 'text', 'required' => true, 'placeholder' => 'Alamat asal sebelum pindah'],
                    ['name' => 'alamat_tujuan', 'label' => 'Alamat Tujuan Pindah', 'type' => 'text', 'required' => true, 'placeholder' => 'Alamat lengkap daerah tujuan baru'],
                    ['name' => 'alasan_pindah', 'label' => 'Alasan Pindah', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Pekerjaan / Urusan Keluarga'],
                ],
                'upload' => [
                    ['name' => 'pengantar_rt', 'label' => 'Surat Pengantar RT/Banjar', 'required' => true, 'accept' => '.jpg,.jpeg,.png,.pdf', 'max' => '2MB'],
                ]
            ],
            'Surat Keterangan Kematian' => [
                'form' => [
                    ['name' => 'nama_almarhum', 'label' => 'Nama Lengkap Almarhum', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama mendiang'],
                    ['name' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal', 'type' => 'date', 'required' => true, 'placeholder' => ''],
                    ['name' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: RS Sanglah / Rumah Tinggal'],
                    ['name' => 'penyebab_meninggal', 'label' => 'Penyebab Meninggal', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Sakit / Usia Tua / Kecelakaan'],
                ],
                'upload' => [
                    ['name' => 'surat_rs', 'label' => 'Surat Keterangan Dokter / RS', 'required' => false, 'accept' => '.pdf,.jpg,.jpeg', 'max' => '2MB'],
                    ['name' => 'pengantar_rt', 'label' => 'Surat Keterangan Banjar/RT', 'required' => true, 'accept' => '.jpg,.jpeg,.png,.pdf', 'max' => '2MB'],
                ]
            ],
            'Surat Keterangan Ahli Waris' => [
                'form' => [
                    ['name' => 'nama_pewaris', 'label' => 'Nama Lengkap Pewaris (Almarhum)', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama almarhum pewaris aset'],
                    ['name' => 'daftar_ahli_waris', 'label' => 'Daftar Nama Ahli Waris', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Anak 1, Anak 2 (Pisahkan dengan koma)'],
                ],
                'upload' => [
                    ['name' => 'akta_kematian', 'label' => 'Scan Akta Kematian', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg', 'max' => '2MB'],
                    ['name' => 'pengantar_rt', 'label' => 'Surat Pengantar RT/Banjar', 'required' => true, 'accept' => '.jpg,.jpeg,.png,.pdf', 'max' => '2MB'],
                ]
            ],
            'Surat Keterangan Kelahiran' => [
                'form' => [
                    ['name' => 'nama_bayi', 'label' => 'Nama Lengkap Bayi', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama anak yang baru lahir'],
                    ['name' => 'tanggal_lahir_bayi', 'label' => 'Tanggal Lahir Bayi', 'type' => 'date', 'required' => true, 'placeholder' => ''],
                    ['name' => 'tempat_lahir_bayi', 'label' => 'Tempat Lahir Bayi', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Denpasar / Klinik Bersalin'],
                    ['name' => 'nama_ayah', 'label' => 'Nama Lengkap Ayah', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama ayah kandung'],
                    ['name' => 'nama_ibu', 'label' => 'Nama Lengkap Ibu', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama ibu kandung'],
                ],
                'upload' => [
                    ['name' => 'surat_bidan', 'label' => 'Surat Keterangan Lahir Bidan/RS', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg', 'max' => '2MB'],
                ]
            ],
        ];

        if (array_key_exists($value, $konfigurasiSurat)) {
            $this->dynamicFormFields = $konfigurasiSurat[$value]['form'];
            $this->dynamicUploadFields = $konfigurasiSurat[$value]['upload'];
        }
    }

    public function ajukanSurat()
    {
        $validationRules = [
            'jenis_surat' => 'required',
            'keperluan' => 'required|string|min:5',
        ];

        foreach ($this->dynamicFormFields as $field) {
            if ($field['required']) {
                $validationRules['data_kustom.' . $field['name']] = 'required';
            }
        }

        foreach ($this->dynamicUploadFields as $upload) {
            if ($upload['required']) {
                $validationRules['bukti_pendukung.' . $upload['name']] = 'required|file|max:2048';
            }
        }

        $this->validate($validationRules);

        $pendudukFisik = Penduduk::where('user_id', Auth::id())->first();

        if ($pendudukFisik) {
           // 🌟 Pemetaan ID Jenis Surat Berurutan Sesuai Database Seeder Terbaru
           $jenisSuratId = match ($this->jenis_surat) {
            'Surat Keterangan Domisili'           => 1,
            'Surat Keterangan Usaha (SKU)'        => 2,
            'Surat Keterangan Tidak Mampu (SKTM)' => 3,
            'Surat Keterangan Kelakuan Baik'      => 4,
            'Surat Pengantar SKCK'                => 5,
            'Surat Pindah'                        => 6,
            'Surat Keterangan Kematian'           => 7,
            'Surat Keterangan Ahli Waris'         => 8,
            'Surat Keterangan Kelahiran'          => 9,
            default                               => 1,
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
                'data_kustom'      => json_encode($this->data_kustom), 
            ]);

            $this->reset(['jenis_surat', 'keperluan', 'bukti_pendukung', 'data_kustom', 'dynamicFormFields', 'dynamicUploadFields']);
            session()->flash('message', 'Pengajuan surat dinamis berhasil dikirim ke server desa!');
        }
    }

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
            $filename = 'donasi_' . time() . '.' . $this->foto_donasi->getClientOriginalExtension();
            $pathFoto = $this->foto_donasi->storeAs('dokumentasi-lumbung/warga', $filename, 'public');

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

        $riwayatDonasi = $dataPenduduk 
            ? BantuanLumbungDesa::where('penduduk_id', $dataPenduduk->id)->where('sumber_input', 'warga')->latest()->get()
            : collect();

        $riwayatPenerimaan = $dataPenduduk
            ? BantuanLumbungDesa::where('penduduk_id', $dataPenduduk->id)
                ->where('sumber_input', '!=', 'warga')
                ->where('status', 'disalurkan')
                ->latest()
                ->get()
            : collect();

        return view('livewire.penduduk.dashboard-penduduk', [
            'penduduk' => $dataPenduduk,
            'riwayatSurat' => $riwayatSurat,
            'daftarPengaduan' => $daftarPengaduan,
            'riwayatDonasi' => $riwayatDonasi, 
            'riwayatPenerimaan' => $riwayatPenerimaan,
        ]);
    }
}