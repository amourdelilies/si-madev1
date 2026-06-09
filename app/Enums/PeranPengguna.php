<?php

namespace App\Enums;

enum PeranPengguna: string
{
    case MASTER_ADMIN = 'master_admin';
    case ADMIN_DESA = 'admin_desa';
    case PENDUDUK = 'penduduk';

    public function label(): string
    {
        return match($this) {
            self::MASTER_ADMIN => 'Master Admin',
            self::ADMIN_DESA => 'Admin Desa',
            self::PENDUDUK => 'Penduduk Warga',
        };
    }
}