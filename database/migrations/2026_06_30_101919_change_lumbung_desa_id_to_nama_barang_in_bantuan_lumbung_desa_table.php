<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bantuan_lumbung_desa', function (Blueprint $table) {
            $table->dropForeign(['lumbung_desa_id']); // Hapus foreign key lama
            $table->dropColumn('lumbung_desa_id');    // Hapus kolom ID
            $table->string('nama_barang')->after('penduduk_id'); // Tambah kolom teks baru
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bantuan_lumbung_desa', function (Blueprint $table) {
            //
        });
    }
};
