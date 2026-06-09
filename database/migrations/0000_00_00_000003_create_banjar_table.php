<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banjar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->onDelete('cascade');
            $table->string('nama_banjar');
            $table->string('ketua_banjar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banjar');
    }
};