<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Penduduk;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    // Mengatur agar data otomatis ter-refresh setiap 10 detik saat demo sidang
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        // 1. Menghitung total penduduk secara real-time dari database
        $totalPenduduk = Penduduk::count();

        // 2. Menghitung penduduk yang status domisili aktif
        $pendudukAktif = Penduduk::where('is_aktif', true)->count();

        // 3. 🔥 SEKARANG OTOMATIS: Menghitung total data dari tabel pengajuan_surat
        $totalSurat = \Illuminate\Support\Facades\DB::table('pengajuan_surat')->count() ?? 0; 

        return [
            Stat::make('Total Penduduk', $totalPenduduk . ' Orang')
                ->description('Semua warga terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 3, 5, 2, 4, 6, $totalPenduduk]),

            Stat::make('Penduduk Aktif', $pendudukAktif . ' Jiwa')
                ->description('Domisili aktif saat ini')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info'),

            Stat::make('Pengajuan Surat', $totalSurat . ' Berkas')
                ->description('Total permohonan layanan')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning')
                ->chart([3, 5, 2, 8, 4, 10, $totalSurat]), // Grafik interaktif untuk surat
        ];
    }
}