<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LumbungDesa extends Model
{
    use HasFactory;

    // 🟢 KUNCI UTAMA: Memaksa Laravel menembak tabel tunggal tanpa akhiran 's'
    protected $table = 'lumbung_desa';

    // Isi array ini sesuai dengan kolom-kolom yang ada di tabel master lumbung_desa-mu
    // Contoh umumnya seperti di bawah ini (sesuaikan dengan nama kolom asli di DB jika berbeda):
    protected $fillable = [
        'penduduk_id',
        'nama_barang',
        'sumber_bantuan',
        'jumlah_bantuan',
        'alasan_keperluan',
        'status',
        'sumber_input',
        'diproses_oleh',
        'disalurkan_pada',
    ];
    // Relasi balik (Inverse Relation) ke riwayat bantuan
    public function bantuanLumbungDesa()
    {
        return $this->hasMany(BantuanLumbungDesa::class, 'lumbung_desa_id');
    }
}
