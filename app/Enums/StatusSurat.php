<?php

namespace App\Enums;

enum StatusSurat: string
{
    case PENDING = 'pending';
    case DIPROSES = 'diproses';
    case DISETUJUI = 'disetujui';
    case DITOLAK = 'ditolak';
    case SELESAI = 'selesai';
}