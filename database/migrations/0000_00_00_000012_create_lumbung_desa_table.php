<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('bantuan_lumbung_desa', function (Blueprint $table) {
        $table->id();
        // Relasi ke warga yang menerima bantuan
        $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
        
        // Relasi ke tabel master lumbung_desa bawaan timmu
        $table->foreignId('lumbung_desa_id')->constrained('lumbung_desa')->onDelete('cascade');
        
        $table->integer('jumlah_bantuan'); 
        $table->text('alasan_keperluan'); 
        
        // Status alur hybrid
        $table->enum('status', ['pending', 'disetujui', 'ditolak', 'disalurkan'])->default('pending');
        
        // Membedakan input Mandiri (warga) vs Distribusi Langsung (admin ke lansia)
        $table->enum('sumber_input', ['warga', 'admin'])->default('warga');
        
        // Mencatat user admin yang memproses/membagikan barang
        $table->foreignId('diproses_oleh')->nullable()->constrained('users')->onDelete('set null');
        $table->timestamp('disalurkan_pada')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('lumbung_desa');
    }
};