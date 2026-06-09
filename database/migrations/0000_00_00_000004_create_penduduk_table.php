<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('banjar_id')->constrained('banjar')->onDelete('cascade');
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('nomor_telepon')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status_akun', ['aktif', 'nonaktif', 'pending'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            // Optimasi performa query
            $table->index('nik');
            $table->index('desa_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};