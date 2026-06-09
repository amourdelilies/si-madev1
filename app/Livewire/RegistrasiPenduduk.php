<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout; // 🌟 Diimpor untuk menghilangkan eror highlight pada layout
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrasiPenduduk extends Component
{
    use WithFileUploads;

    // Properti Form Kependudukan
    public $nik, $no_kk, $nama_lengkap, $tempat_lahir, $tanggal_lahir;
    public $jenis_kelamin, $status_perkawinan, $pekerjaan, $alamat;
    
    // Properti Berkas Digital
    public $foto_ktp, $foto_kk;

    protected $rules = [
        'nik' => 'required|digits:16|unique:penduduk,nik',
        'no_kk' => 'required|digits:16',
        'nama_lengkap' => 'required|string|max:255',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'status_perkawinan' => 'required',
        'pekerjaan' => 'required',
        'alamat' => 'required',
        'foto_ktp' => 'required|image|max:2048', // Wajib diunggah & maksimal 2MB
        'foto_kk' => 'required|image|max:2048',  // Wajib diunggah & maksimal 2MB
    ];

    // 🌟 FUNGSI OTOMATIS ISI DATA (SEKARANG NAMA & NIK ACAK OTOMATIS)
    public function isiDataOtomatis()
    {
        // 1. Membuat 4 digit acak di belakang NIK agar selalu unik
        $digitAcak = rand(1000, 9999); 
        $this->nik = '510202170899' . $digitAcak;
        $this->no_kk = '5102021504090015';

        // 2. Daftar pilihan nama dummy Bali acak beserta jenis kelaminnya
        $daftarNama = [
            ['nama' => 'I Made Dharma Wijaya', 'jk' => 'L'],
            ['nama' => 'Ni Putu Ayu Saraswati', 'jk' => 'P'],
            ['nama' => 'I Gede Putu Mahendra', 'jk' => 'L'],
            ['nama' => 'Ni Luh Made Adriani Raisa', 'jk' => 'P'],
            ['nama' => 'I Nyoman Wayan Juniarta', 'jk' => 'L'],
            ['nama' => 'Ni Ketut Sri Wahyuni', 'jk' => 'P'],
        ];

        // 3. Mengambil salah satu data nama secara acak
        $pilihanAcak = $daftarNama[array_rand($daftarNama)];

        // 4. Memasukkan hasil acak ke dalam form
        $this->nama_lengkap = $pilihanAcak['nama'];
        $this->jenis_kelamin = $pilihanAcak['jk'];

        // 5. Sisa data pelengkap lainnya
        $this->tempat_lahir = 'Denpasar';
        $this->tanggal_lahir = '1999-02-11';
        $this->status_perkawinan = 'Belum Kawin';
        $this->pekerjaan = 'Tenaga Medis';
        $this->alamat = 'Jl. Dalia XII No. 40';
    }

    public function simpan()
    {
        $this->validate();

        // 1. Menyimpan berkas digital ke storage/app/public/berkas
        $pathKtp = $this->foto_ktp->store('berkas/ktp', 'public');
        $pathKk = $this->foto_kk->store('berkas/kk', 'public');

        // 2. Otomatis buatkan akun User untuk login dashboard (Username = NIK, Password = No KK)
        $user = User::create([
            'name' => $this->nama_lengkap,
            'email' => $this->nik . '@simade.id', // Email tiruan unik berbasis NIK warga
            'password' => Hash::make($this->no_kk), // Password bawaan adalah Nomor KK
        ]);

        // 3. Simpan data ke tabel penduduk dengan status non-aktif (is_aktif = false)
        Penduduk::create([
            'user_id' => $user->id, // Menghubungkan data penduduk ke akun login
            'nik' => $this->nik,
            'no_kk' => $this->no_kk,
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status_perkawinan' => $this->status_perkawinan,
            'pekerjaan' => $this->pekerjaan,
            'alamat' => $this->alamat,
            'foto' => $pathKtp,   // Jalur foto KTP ke database
            'foto_kk' => $pathKk, // Jalur foto KK ke database
            'is_aktif' => false, 
        ]);

        // 4. Otomatis loginkan warga yang baru daftar ini
        Auth::login($user);

        // 5. Alihkan langsung ke halaman dashboard penduduk mandiri
        return redirect()->route('penduduk.dashboard');
    }

    // 🌟 Menggunakan Atribut PHP untuk mendeklarasikan layout 'welcome'. 
    #[Layout('welcome')] 
    public function render()
    {
        return view('livewire.registrasi-penduduk'); 
    }
}