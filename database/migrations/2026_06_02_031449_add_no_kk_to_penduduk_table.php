<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            // Menambahkan kolom no_kk berkapasitas 16 karakter tepat di bawah kolom nik
            $table->string('no_kk', 16)->after('nik')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            // Menghapus kembali kolom no_kk jika migrasi di-rollback
            $table->dropColumn('no_kk');
        });
    }
};