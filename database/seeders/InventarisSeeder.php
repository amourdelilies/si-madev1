<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarisSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kosongkan tabel terlebih dahulu untuk menghindari bentrok data kembar
        DB::table('inventaris')->truncate();

        // 2. Suntik data baru secara massal
        DB::table('inventaris')->insert([
            [
                'kode_barang' => 'INV/SMD/2026/001',
                'nama_barang' => 'Laptop ASUS ExpertBook',
                'kategori' => 'Elektronik',
                'foto_barang' => null,
                'merek_spesifikasi' => 'Core i5, RAM 8GB, SSD 512GB',
                'jumlah' => 3,
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Pelayanan Publik',
                'penanggung_jawab' => 'Kaur Umum',
                'sumber_perolehan' => 'APBDes 2026',
                'tanggal_pengadaan' => '2026-01-15',
                'catatan' => 'Digunakan untuk staf admin cetak surat warga',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/002',
                'nama_barang' => 'Printer Epson L3210',
                'kategori' => 'Elektronik',
                'foto_barang' => null,
                'merek_spesifikasi' => 'L3210 Ink Tank',
                'jumlah' => 2,
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Sekretariat',
                'penanggung_jawab' => 'Staf Tata Usaha',
                'sumber_perolehan' => 'APBDes 2026',
                'tanggal_pengadaan' => '2026-01-20',
                'catatan' => 'Printer cetak dokumen dan kartu kependudukan',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/003',
                'nama_barang' => 'Proyektor BenQ MX550',
                'kategori' => 'Elektronik',
                'foto_barang' => null,
                'merek_spesifikasi' => 'BenQ MX550 XGA',
                'jumlah' => 1,
                'kondisi' => 'rusak_ringan',
                'lokasi' => 'Ruang Rapat Utama',
                'penanggung_jawab' => 'Sekdes',
                'sumber_perolehan' => 'APBDes 2026',
                'tanggal_pengadaan' => '2026-02-10',
                'catatan' => 'Lampu agak redup, butuh servis berkala',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/004',
                'nama_barang' => 'Kursi Plastik Napolly',
                'kategori' => 'Sarana Komunitas',
                'foto_barang' => null,
                'merek_spesifikasi' => 'Napolly Big 101',
                'jumlah' => 150,
                'kondisi' => 'baik',
                'lokasi' => 'Gudang Logistik B',
                'penanggung_jawab' => 'Kelian Banjar Dinas',
                'sumber_perolehan' => 'Swadaya Masyarakat',
                'tanggal_pengadaan' => '2026-03-05',
                'catatan' => 'Sering dipinjam warga untuk acara suka duka',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/005',
                'nama_barang' => 'Tenda Besi Lipat 4x6',
                'kategori' => 'Sarana Komunitas',
                'foto_barang' => null,
                'merek_spesifikasi' => 'Rangka Besi Hollow Galvanis',
                'jumlah' => 4,
                'kondisi' => 'baik',
                'lokasi' => 'Gudang Logistik A',
                'penanggung_jawab' => 'Kaur Umum',
                'sumber_perolehan' => 'Hibah Pemprov Bali',
                'tanggal_pengadaan' => '2026-03-12',
                'catatan' => 'Tenda milik desa untuk fasilitas umum',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/006',
                'nama_barang' => 'Sound System Portable BareTone',
                'kategori' => 'Sarana Komunitas',
                'foto_barang' => null,
                'merek_spesifikasi' => 'BareTone MAX15HB',
                'jumlah' => 2,
                'kondisi' => 'baik',
                'lokasi' => 'Balai Pertemuan Desa',
                'penanggung_jawab' => 'Staf Kebudayaan',
                'sumber_perolehan' => 'APBDes 2026',
                'tanggal_pengadaan' => '2026-04-02',
                'catatan' => 'Digunakan saat rapat pleno atau sosialisasi warga',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/007',
                'nama_barang' => 'Honda Suprax 125 Dinas',
                'kategori' => 'Kendaraan',
                'foto_barang' => null,
                'merek_spesifikasi' => 'Honda Supra X 125 FI',
                'jumlah' => 2,
                'kondisi' => 'baik',
                'lokasi' => 'Parkir Dalam Kantor',
                'penanggung_jawab' => 'Kepala Desa / Kades',
                'sumber_perolehan' => 'Pemerintah Daerah',
                'tanggal_pengadaan' => '2026-02-18',
                'catatan' => 'Kendaraan operasional lapangan perangkat desa',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/008',
                'nama_barang' => 'Motor Viar Roda Tiga Pengangkut Sampah',
                'kategori' => 'Kendaraan',
                'foto_barang' => null,
                'merek_spesifikasi' => 'Viar Karya 200 cc',
                'jumlah' => 1,
                'kondisi' => 'baik',
                'lokasi' => 'Area TPS3R Desa',
                'penanggung_jawab' => 'Ketua Swadaya Sampah',
                'sumber_perolehan' => 'Dana Desa 2026',
                'tanggal_pengadaan' => '2026-05-10',
                'catatan' => 'Operasional kebersihan lingkungan banjar/dusun',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/009',
                'nama_barang' => 'Alat Pemadam Api Ringan (APAR) Co2',
                'kategori' => 'Keamanan',
                'foto_barang' => null,
                'merek_spesifikasi' => 'APAR CO2 5kg',
                'jumlah' => 5,
                'kondisi' => 'baik',
                'lokasi' => 'Koridor Ruang Publik',
                'penanggung_jawab' => 'Kaur Kesra',
                'sumber_perolehan' => 'APBDes 2026',
                'tanggal_pengadaan' => '2026-01-22',
                'catatan' => 'Tabung pemadam darurat diletakkan di tiap sudut',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'kode_barang' => 'INV/SMD/2026/010',
                'nama_barang' => 'Mesin Pompa Air Alkon (Banjir)',
                'kategori' => 'Keamanan',
                'foto_barang' => null,
                'merek_spesifikasi' => 'Alkon 3 Inch Yamaha',
                'jumlah' => 1,
                'kondisi' => 'rusak_berat',
                'lokasi' => 'Gudang Peralatan C',
                'penanggung_jawab' => 'Kasie Pemerintahan',
                'sumber_perolehan' => 'Hibah BNPB',
                'tanggal_pengadaan' => '2026-05-25',
                'catatan' => 'Mesin mati total akibat terendam lumpur banjir',
                'created_at' => now(), 'updated_at' => now()
            ],
        ]);
    }
}