<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('restrict');
            $table->text('keperluan');
            $table->enum('status', ['pending', 'diproses', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->string('jalur_pdf')->nullable();
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('disetujui_pada')->nullable();
            $table->timestamps();

            // Optimasi performa tracking
            $table->index('status');
            $table->index('penduduk_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};