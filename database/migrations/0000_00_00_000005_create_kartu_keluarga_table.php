<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Langkah 1: Buat tabel kartu_keluarga tanpa mengunci ke tabel penduduk dulu
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kk', 16)->unique();
            $table->unsignedBigInteger('kepala_keluarga_id')->nullable(); // Set biasa dulu tanpa constrained
            $table->foreignId('banjar_id')->constrained('banjar')->onDelete('cascade');
            $table->text('alamat');
            $table->timestamps();
        });

        // Langkah 2: Daftarkan penguncian (foreign key) setelah tabel penduduk dipastikan aman dibuat
        // Kita gunakan skema append setelah tabel penduduk dipastikan ada oleh Laravel
        if (Schema::hasTable('penduduk')) {
            Schema::table('kartu_keluarga', function (Blueprint $table) {
                $table->foreign('kepala_keluarga_id')->references('id')->on('penduduk')->onDelete('restrict');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_keluarga');
    }
};