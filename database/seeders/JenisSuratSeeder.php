<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisSurat;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarSurat = [
            ['id' => 1, 'nama_surat' => 'Surat Keterangan Domisili', 'slug' => 'surat-keterangan-domisili'],
            ['id' => 2, 'nama_surat' => 'Surat Keterangan Usaha (SKU)', 'slug' => 'surat-keterangan-usaha-sku'],
            ['id' => 3, 'nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)', 'slug' => 'surat-keterangan-tidak-mampu-sktm'],
            ['id' => 4, 'nama_surat' => 'Surat Keterangan Kelakuan Baik', 'slug' => 'surat-keterangan-kelakuan-baik'],
            ['id' => 5, 'nama_surat' => 'Surat Pengantar SKCK', 'slug' => 'surat-pengantar-skck'],
            ['id' => 6, 'nama_surat' => 'Surat Pindah', 'slug' => 'surat-pindah'],
            ['id' => 7, 'nama_surat' => 'Surat Keterangan Kematian', 'slug' => 'surat-keterangan-kematian'],
            ['id' => 8, 'nama_surat' => 'Surat Keterangan Ahli Waris', 'slug' => 'surat-keterangan-ahli-waris'],
            ['id' => 9, 'nama_surat' => 'Surat Keterangan Kelahiran', 'slug' => 'surat-keterangan-kelahiran'],
        ];

        foreach ($daftarSurat as $surat) {
            JenisSurat::updateOrCreate(
                ['id' => $surat['id']], 
                [
                    'nama_surat' => $surat['nama_surat'],
                    'slug' => $surat['slug']
                ]
            );
        }
    }
}