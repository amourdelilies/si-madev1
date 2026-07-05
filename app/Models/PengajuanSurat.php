<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    // 🌟 Mendaftarkan data_kustom agar diizinkan masuk dan disimpan oleh Laravel
    protected $fillable = [
        'penduduk_id',
        'jenis_surat',
        'alasan_pengajuan',
        'jenis_surat_id',
        'keperluan',
        'data_kustom', // 🌟 Selesai ditambahkan!
        'bukti_pendukung',
        'status',
        'catatan_admin',
        'nomor_surat',
        'jalur_pdf',
        'diproses_oleh',
        'disetujui_pada'
    ];

    /**
     * Relasi ke data Penduduk
     */
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    /**
     * Relasi ke data Jenis Surat (Jika timmu menggunakan tabel Master Jenis Surat)
     */
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }
}