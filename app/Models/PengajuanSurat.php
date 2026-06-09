<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    // 🌟 MEMBUKA GERBANG IZIN KOLOM DATABASE UNTUK FITUR BARU KITA
    protected $fillable = [
        'penduduk_id',
        'jenis_surat',
        'keperluan',
        'status',
        'keterangan_admin',
    ];

    // Relasi ke data Penduduk
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }
}