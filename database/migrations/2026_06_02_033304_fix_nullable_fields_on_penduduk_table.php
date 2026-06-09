<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            // Mengubah ketiga kolom kunci agar boleh kosong saat warga daftar mandiri
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('banjar_id')->nullable()->change();
            $table->foreignId('desa_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreignId('banjar_id')->nullable(false)->change();
            $table->foreignId('desa_id')->nullable(false)->change();
        });
    }
};