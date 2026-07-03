<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantuanLumbungDesa extends Model
{
    use HasFactory;

    protected $table = 'bantuan_lumbung_desa';

    // 🟢 WAJIB MASUKKAN SEMUA KOLOM BARU DI SINI:
    protected $fillable = [
        'penduduk_id',       // ID Penerima Warga
        'nama_barang',       // Kolom input teks manual baru
        'sumber_bantuan',    // Kolom pilihan sumber baru
        'keterangan_program',// Kolom nama program/No SK baru
        'jumlah_bantuan',
        'alasan_keperluan',
        'status',
        'sumber_input',
        'diproses_oleh',
        'disalurkan_pada',
        'foto_penyerahan_desa',
    'foto_penerimaan_warga',
    ];

    // Relasi ke model Penduduk
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }
}