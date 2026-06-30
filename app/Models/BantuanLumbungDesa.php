<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantuanLumbungDesa extends Model
{
    use HasFactory;

    protected $table = 'bantuan_lumbung_desa';

    protected $fillable = [
        'penduduk_id',
        'lumbung_desa_id',
        'jumlah_bantuan',
        'alasan_keperluan',
        'status',
        'sumber_input',
        'diproses_oleh',
        'disalurkan_pada',
    ];

    // Relasi ke data Penduduk
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    // Relasi ke data Master Lumbung Desa
    public function lumbungDesa()
    {
        return $this->belongsTo(LumbungDesa::class, 'lumbung_desa_id');
    }

    // Relasi ke Admin/User yang memproses
    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}