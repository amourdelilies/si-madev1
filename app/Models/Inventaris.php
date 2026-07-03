<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';
    protected $guarded = [];

    // Jika kamu punya tabel Desa, bisa relasikan ke desa_id lama kamu
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}