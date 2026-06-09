<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            // Mengubah kolom banjar_id agar tipenya nullable (boleh kosong saat warga daftar mandiri)
            $table->foreignId('banjar_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->foreignId('banjar_id')->nullable(false)->change();
        });
    }
};