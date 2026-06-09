<?php

namespace App\Enums;

enum StatusPengaduan: string
{
    case DIKIRIM = 'dikirim';
    case DIPROSES = 'diproses';
    case SELESAI = 'selesai';
}