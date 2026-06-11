<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    // Nama tabel di database Anda (pastikan sesuai, misal 'penduduk')
    protected $table = 'penduduk'; 

    // 🌟 PERBAIKAN: Pastikan 'user_id' didaftarkan di baris paling atas $fillable
    protected $fillable = [
        'user_id', 
        'nik',
        'no_kk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_perkawinan',
        'pekerjaan',
        'alamat',
        'foto_ktp',
        'foto_kk',
        'is_aktif',
    ];

    // Relasi ke tabel User (Opsional tapi sangat baik untuk dosen Anda)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}