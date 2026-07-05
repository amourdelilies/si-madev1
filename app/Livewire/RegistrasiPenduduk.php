<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout; 
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker; // 🌟 Diimpor untuk generate data acak nasional Indonesia

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
        'foto_ktp' => 'required|image|max:2048', 
        'foto_kk' => 'required|image|max:2048',  
    ];

    // 🌟 FUNGSI OTOMATIS ISI DATA (SEKARANG MURNI ACAK INDONESIA TANPA DUPLIKAT DATA LAMA)
    public function isiDataOtomatis()
    {
        // 1. Inisialisasi Faker dengan regional Indonesia (id_ID)
        $faker = Faker::create('id_ID');

        // 2. Membuat digit acak unik untuk NIK & No KK agar tidak melanggar Unique Constraint
        $this->nik = '510202' . $faker->numerify('##########');
        $this->no_kk = '510202' . $faker->numerify('##########');

        // 3. Mengacak Jenis Kelamin
        $this->jenis_kelamin = $faker->randomElement(['L', 'P']);

        // 4. Membuat Nama Acak Indonesia asli bawaan sistem berdasarkan gender (Menghindari Nama Bali yang Sudah Ada)
        $this->nama_lengkap = $this->jenis_kelamin === 'L' ? $faker->name('male') : $faker->name('female');

        // 5. Mengisi data penunjang lainnya secara acak dan realistis
        $this->tempat_lahir = $faker->city;
        $this->tanggal_lahir = $faker->date('Y-m-d', '2005-01-01'); // Batas umur acak maksimal kelahiran 2005
        $this->status_perkawinan = $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup']);
        $this->pekerjaan = $faker->randomElement(['Karyawan Swasta', 'Wiraswasta', 'Petani', 'Pelajar/Mahasiswa', 'Tenaga Medis']);
        $this->alamat = $faker->address;
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
            'email' => $this->nik . '@simade.id', 
            'password' => Hash::make($this->no_kk), 
        ]);

        // 3. Simpan data ke tabel penduduk dengan status non-aktif (is_aktif = false)
        Penduduk::create([
            'user_id' => $user->id, 
            'nik' => $this->nik,
            'no_kk' => $this->no_kk,
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status_perkawinan' => $this->status_perkawinan,
            'pekerjaan' => $this->pekerjaan,
            'alamat' => $this->alamat,
            'foto_ktp' => $pathKtp,   
            'foto_kk' => $pathKk, 
            'is_aktif' => false, 
        ]);

        // 4. Otomatis loginkan warga yang baru daftar ini
        Auth::login($user);

        // 5. Alihkan langsung ke halaman dashboard penduduk mandiri
        return redirect()->route('penduduk.dashboard');
    }

    #[Layout('welcome')] 
    public function render()
    {
        return view('livewire.registrasi-penduduk'); 
    }
}