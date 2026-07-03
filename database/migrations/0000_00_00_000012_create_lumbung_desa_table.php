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
        
        // Relasi ke warga (menembak id di tabel penduduk)
        $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
        
        // Ketik manual nama barang & input sumber bantuan (pemerintah/dana desa)
        $table->string('nama_barang'); 
        $table->string('sumber_bantuan');
        $table->integer('jumlah_bantuan');
        
        $table->text('alasan_keperluan')->nullable();
        $table->string('status')->default('pending'); // pending, diproses, disetujui, selesai
        $table->string('sumber_input')->default('admin');
        $table->foreignId('diproses_oleh')->nullable()->constrained('users');
        $table->timestamp('disalurkan_pada')->nullable();
        
        $table->timestamps();
    });

}

    public function down(): void
    {
        Schema::dropIfExists('lumbung_desa');
    }
};