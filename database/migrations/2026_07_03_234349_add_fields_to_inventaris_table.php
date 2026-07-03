<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            // Menambahkan field esensial baru tanpa menghapus kolom lama kamu
            $table->string('kode_barang')->unique()->after('id'); // Kode Unik untuk QR Code
            $table->string('foto_barang')->nullable()->after('kategori'); // Foto Fisik
            $table->string('merek_spesifikasi')->nullable()->after('foto_barang'); // Spesifikasi Barang
            
            // Kolom administrasi & audit aset desa
            $table->string('penanggung_jawab')->after('lokasi'); 
            $table->string('sumber_perolehan')->after('penanggung_jawab'); 
            $table->date('tanggal_pengadaan')->after('sumber_perolehan'); 
            $table->text('catatan')->nullable()->after('tanggal_pengadaan'); 
        });
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn([
                'kode_barang', 
                'foto_barang', 
                'merek_spesifikasi', 
                'penanggung_jawab', 
                'sumber_perolehan', 
                'tanggal_pengadaan', 
                'catatan'
            ]);
        });
    }
};