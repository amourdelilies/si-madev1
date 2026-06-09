<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

    {
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            
            // 
            $table->string('jenis_surat'); 
            $table->text('keperluan');    
            
            $table->string('bukti_pendukung')->nullable(); // Kolom bukti pendukung opsional kita tadi
            $table->string('status')->default('pending'); 
            $table->text('keterangan_admin')->nullable(); 
            $table->timestamps();
        });
    }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};