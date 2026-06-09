<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            $table->string('judul_pengaduan');
            $table->text('deskripsi_pengaduan');
            $table->enum('kategori', ['infrastruktur', 'kebersihan', 'pelayanan', 'keamanan']);
            $table->enum('status', ['dikirim', 'diproses', 'selesai'])->default('dikirim');
            $table->text('tindak_lanjut')->nullable();
            $table->foreignId('ditangani_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};