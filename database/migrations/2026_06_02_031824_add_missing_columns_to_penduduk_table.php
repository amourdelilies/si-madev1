<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            // Cek jika kolom status_perkawinan belum ada, maka buatkan
            if (!Schema::hasColumn('penduduk', 'status_perkawinan')) {
                $table->string('status_perkawinan')->after('jenis_kelamin')->nullable();
            }
            
            // Pengaman ekstra: Cek jika ada kolom lain yang mendadak hilang
            if (!Schema::hasColumn('penduduk', 'pekerjaan')) {
                $table->string('pekerjaan')->after('status_perkawinan')->nullable();
            }
            if (!Schema::hasColumn('penduduk', 'is_aktif')) {
                $table->boolean('is_aktif')->default(false)->after('alamat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn(['status_perkawinan', 'pekerjaan', 'is_aktif']);
        });
    }
};