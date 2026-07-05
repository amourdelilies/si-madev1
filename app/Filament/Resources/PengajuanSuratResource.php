<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajuanSuratResource\Pages;
use App\Models\PengajuanSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PengajuanSuratResource extends Resource
{
    protected static ?string $model = PengajuanSurat::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Permohonan Surat';
    protected static ?string $pluralModelLabel = 'Permohonan Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Select::make('penduduk_id')
                            ->relationship('penduduk', 'nama_lengkap')
                            ->disabled() 
                            ->required(),
                            
                        Forms\Components\Select::make('jenis_surat_id')
                            ->relationship('jenisSurat', 'nama_surat')
                            ->disabled()
                            ->required(),
                            
                        Forms\Components\Textarea::make('keperluan')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('bukti_pendukung')
                            ->label('Dokumen Persyaratan Wajib (Berkas Warga)')
                            ->content(fn ($record) => 
                                $record && $record->bukti_pendukung 
                                    ? new \Illuminate\Support\HtmlString(
                                        collect(json_decode($record->bukti_pendukung, true))
                                            ->map(function($path, $key) use ($record) {
                                                $labelName = match($key) {
                                                    'rekomendasi_banjar' => 'SURAT_PENGANTAR',
                                                    'pengantar_rt'       => 'SURAT_PENGANTAR_RT_RW',
                                                    'foto_usaha'         => 'FOTO_FISIK_TEMPAT_USAHA',
                                                    'nota_insidentil'    => 'NOTA_PEMBELIAN_INVENTARIS',
                                                    'foto_rumah'         => 'FOTO_RUMAH_TINGGAL',
                                                    'pas_foto'           => 'PAS_FOTO_WARGA',
                                                    'bukti_tinggal'      => 'BUKTI_TEMPAT_TINGGAL',
                                                    'surat_rs'           => 'SURAT_KETERANGAN_MEDIS',
                                                    'akta_kematian'      => 'SCAN_AKTA_KEMATIAN',
                                                    'surat_bidan'        => 'SURAT_LAHIR_BIDAN_RS',
                                                    default              => strtoupper($key)
                                                };

                                                $namaWarga = ($record && $record->penduduk) ? str_replace(' ', '_', $record->penduduk->nama_lengkap) : 'WARGA';
                                                $downloadName = $namaWarga . '-' . $labelName;

                                                return "
                                                    <div style='background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; margin-bottom: 12px;'>
                                                        <div style='font-weight: 700; font-size: 0.75rem; color: #4b5563; letter-spacing: 0.05em; text-transform: uppercase;'>
                                                            " . str_replace('_', ' ', $labelName) . "
                                                        </div>
                                                        <div style='margin-top: 8px; display: flex; gap: 12px;'>
                                                            <a href='" . asset('storage/' . $path) . "' target='_blank' style='display: inline-block; padding: 4px 12px; background-color: #3b82f6; color: #ffffff; font-size: 0.75rem; font-weight: 700; border-radius: 6px; text-decoration: none;'>Lihat Dokumen</a>
                                                            <a href='" . asset('storage/' . $path) . "' download='" . $downloadName . "' style='display: inline-block; padding: 4px 12px; background-color: #10b981; color: #ffffff; font-size: 0.75rem; font-weight: 700; border-radius: 6px; text-decoration: none;'>Unduh Dokumen</a>
                                                        </div>
                                                    </div>
                                                ";
                                            })->implode('')
                                    )
                                    : 'Warga tidak melampirkan berkas pendukung.'
                            )
                            ->columnSpanFull(),
                    ])->columns(2),
                ])->columnSpan(2),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'   => 'Pending',
                                'disetujui' => 'Disetujui',
                                'ditolak'   => 'Ditolak',
                            ])
                            ->required()
                            ->native(false),
                            
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Alasan Ditolak / Catatan')
                            ->placeholder('Tulis alasan jika berkas warga salah/ditolak'),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Masuk')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('penduduk.nama_lengkap')->label('Nama Pemohon')->searchable(),
                Tables\Columns\TextColumn::make('jenisSurat.nama_surat')->label('Jenis Surat'),
                Tables\Columns\TextColumn::make('nomor_surat')->label('No. Surat')->placeholder('Belum Terbit'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'gray',
                        'disetujui' => 'info',
                        'ditolak'   => 'danger',
                        default     => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Proses Surat'),

                Action::make('preview_surat')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Pratinjau Dokumen Surat')
                    ->modalSubmitAction(false)
                    ->modalContent(fn ($record) => view('surat.preview', [
                        'record' => $record,
                        'data_surat' => json_decode($record->data_kustom, true) ?? [],
                        'warga' => $record->penduduk,
                        'nomor_surat' => $record->nomor_surat ?? '470/XXX/KODE/ROM/'.date('Y'),
                        'tanggal_cetak' => Carbon::parse($record->disetujui_pada ?? now())->translatedFormat('d F Y')
                    ])),

                Action::make('setujui_otomatis')
                    ->label('Setujui & Buat PDF')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => strtolower($record->status) === 'pending')
                    ->action(function ($record) {
                        // Memaksa sistem internal melokalisasi penulisan tanggal ke Bahasa Indonesia murni
                        Carbon::setLocale('id');
                        config(['app.locale' => 'id']);
                        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id');

                        $now = Carbon::now();
                        $tahun = $now->year;
                        
                        $array_bln = [1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
                        $bulanRomawi = $array_bln[$now->month];
                        
                        // KUNCI INCREMENT OTOMATIS BERDASARKAN JENIS SURAT
                        $urutanSurat = PengajuanSurat::whereYear('created_at', $tahun)
                            ->where('status', 'disetujui')
                            ->where('jenis_surat_id', $record->jenis_surat_id)
                            ->count() + 1;
                        
                        $kodeSurat = match($record->jenisSurat->slug ?? 'surat') {
                            'surat-keterangan-domisili'         => 'DOM',
                            'surat-keterangan-usaha-sku'        => 'SKU',
                            'surat-keterangan-tidak-mampu-sktm' => 'SKTM',
                            'surat-keterangan-kelakuan-baik'    => 'SKB',
                            'surat-pengantar-skck'              => 'SKCK',
                            'surat-pindah'                      => 'PNDH',
                            'surat-keterangan-kematian'         => 'KMTN',
                            'surat-keterangan-ahli-waris'       => 'WARIS',
                            'surat-keterangan-kelahiran'        => 'KLHRN',
                            default                             => 'SRT',
                        };

                        $nomorOtomatis = sprintf("470/%03d/%s/%s/%d", $urutanSurat, $kodeSurat, $bulanRomawi, $tahun);
                        $templatePath = 'surat.template_master';

                        $dataUntukPdf = [
                            'nomor_surat'   => $nomorOtomatis,
                            'warga'         => $record->penduduk,
                            'data_surat'    => json_decode($record->data_kustom, true) ?? [],
                            'tanggal_cetak' => $now->translatedFormat('d F Y'),
                            'record'        => $record,
                            'tte_kades'     => true // Flag pemicu cetak gambar TTE di berkas pisah Blade
                        ];

                        $pdf = Pdf::loadView($templatePath, $dataUntukPdf)->setPaper('a4', 'portrait');
                        $namaFile = strtoupper(str_replace('-', '_', $record->jenisSurat->slug ?? 'STANDAR')) . "-{$tahun}-" . sprintf("%03d", $urutanSurat) . ".pdf";
                        
                        $publicPath = public_path('surat_keluar');
                        if (!file_exists($publicPath)) {
                            mkdir($publicPath, 0755, true);
                        }

                        file_put_contents($publicPath . '/' . $namaFile, $pdf->output());
                        $pathSimpan = "surat_keluar/" . $namaFile;

                        $record->update([
                            'status'         => 'disetujui',
                            'nomor_surat'    => $nomorOtomatis,
                            'jalur_pdf'      => $pathSimpan,
                            'disetujui_pada' => $now
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Surat Berhasil Diarsip!')
                            ->body("Nomor {$nomorOtomatis} telah diterbitkan.")
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPengajuanSurats::route('/'),
            'create' => Pages\CreatePengajuanSurat::route('/create'),
            'edit'  => Pages\EditPengajuanSurat::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
{
    // Otomatis memunculkan jumlah pengajuan yang statusnya masih pending/belum diproses
    return static::getModel()::where('status', 'pending')->count() ?: null;
}

// Opsional: Memberikan warna merah/kuning menyala pada badge notifikasinya
public static function getNavigationBadgeColor(): ?string
{
    return 'warning'; // atau 'danger' (merah)
}
}