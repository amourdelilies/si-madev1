<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PendudukDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Menggunakan locale Indonesia agar nama dan alamat yang di-generate lokal
        $faker = Faker::create('id_ID');
        
        $pekerjaan = ['Tenaga Medis', 'Karyawan Swasta', 'Wiraswasta', 'Petani', 'Belum/Tidak Bekerja', 'Pelajar/Mahasiswa'];
        $dataPenduduk = [];

        for ($i = 1; $i <= 50; $i++) {
            // NIK & KK otomatis berurutan agar tetap mudah diketik saat demo
            $nikOtomatis = "51020217" . sprintf("%08d", $i + 300); // Start offset diubah agar tidak bentrok
            $kkOtomatis  = "51020220" . sprintf("%08d", $i + 700);
            
            // Mengacak jenis kelamin
            $jk = $faker->randomElement(['L', 'P']);
            // Generate nama acak sesuai jenis kelamin dari Faker Indonesia
            $namaLengkap = $jk === 'L' ? $faker->name('male') : $faker->name('female');

            $dataPenduduk[] = [
                'nik'               => $nikOtomatis,
                'no_kk'             => $kkOtomatis,
                'nama_lengkap'      => $namaLengkap,
                'tempat_lahir'      => $faker->city,
                'tanggal_lahir'     => $faker->date('Y-m-d', '2005-01-01'), // Kelahiran acak maksimal 2005
                'jenis_kelamin'     => $jk,
                'status_perkawinan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup']),
                'pekerjaan'         => $faker->randomElement($pekerjaan),
                'alamat'            => $faker->address,
                'is_aktif'          => true,
                'foto'              => null, 
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }

        // Jalankan truncate untuk membersihkan dummy sebelumnya, atau comment baris ini jika tak ingin menghapus
        DB::table('penduduk')->truncate();

        // Suntik massal ke database
        DB::table('penduduk')->insert($dataPenduduk);
    }
}