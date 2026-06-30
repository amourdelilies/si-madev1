<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        {
            \App\Models\JenisSurat::updateOrCreate(['id' => 1], ['nama_surat' => 'Surat Keterangan Domisili']);
            \App\Models\JenisSurat::updateOrCreate(['id' => 2], ['nama_surat' => 'Surat Keterangan Usaha (SKU)']);
            \App\Models\JenisSurat::updateOrCreate(['id' => 3], ['nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)']);
            \App\Models\JenisSurat::updateOrCreate(['id' => 4], ['nama_surat' => 'Surat Keterangan Kelakuan Baik']);
        }
    }
}
