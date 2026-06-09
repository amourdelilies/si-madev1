<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    // Kunci nama tabel agar Laravel tidak mencari 'jenis_surats'
    protected $table = 'jenis_surat'; 

    protected $fillable = [
        'nama_surat',
        'slug',
        'deskripsi',
        'persyaratan',
        'jalur_templat',
        'is_aktif',
    ];

    protected $casts = [
        'persyaratan' => 'array',
        'is_aktif' => 'boolean',
    ];

    // Relasi ke pengajuan surat
    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class, 'jenis_surat_id');
    }
}