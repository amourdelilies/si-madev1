<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    // Karena nama tabelnya tunggal, wajib didefinisikan secara eksplisit
    protected $table = 'pengaduan';

    protected $fillable = [
        'penduduk_id',
        'judul_pengaduan',
        'deskripsi_pengaduan',
        'kategori',
        'status',
        'tindak_lanjut',
        'ditangani_oleh'
    ];

    // Relasi ke tabel Penduduk
    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    // Relasi ke Admin/User yang menangani
    public function penanggungJawab(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
}