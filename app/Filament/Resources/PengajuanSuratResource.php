<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajuanSuratResource\Pages;
use App\Models\PengajuanSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                // Kiri: Detail Informasi Pemohon & Berkas Persyaratan
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

                        // Tampilan Berkas Warga yang Sudah Menggunakan Layout Card & Bold Text
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
                                                    default              => strtoupper($key)
                                                };

                                                $namaWarga = ($record && $record->penduduk) 
                                                    ? str_replace(' ', '_', $record->penduduk->nama_lengkap) 
                                                    : 'WARGA';

                                                $downloadName = $namaWarga . '-' . $labelName;

                                                return "
                                                    <div style='background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; margin-bottom: 12px;'>
                                                        <div style='font-weight: 700; font-size: 0.75rem; color: #4b5563; letter-spacing: 0.05em; text-transform: uppercase;'>
                                                            " . str_replace('_', ' ', $labelName) . "
                                                        </div>
                                                        <div style='margin-top: 8px; display: flex; gap: 12px;'>
                                                            <a href='" . asset('storage/' . $path) . "' target='_blank' style='display: inline-block; padding: 4px 12px; background-color: #3b82f6; color: #ffffff; font-size: 0.75rem; font-weight: 700; border-radius: 6px; text-decoration: none;'>
                                                                Lihat Dokumen
                                                            </a>
                                                            <a href='" . asset('storage/' . $path) . "' download='" . $downloadName . "' style='display: inline-block; padding: 4px 12px; background-color: #10b981; color: #ffffff; font-size: 0.75rem; font-weight: 700; border-radius: 6px; text-decoration: none;'>
                                                                Unduh Dokumen
                                                            </a>
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

                // Kanan: Validasi Status, Nomor Surat, & FileUpload yang Benar
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
                            
                        Forms\Components\TextInput::make('nomor_surat')
                            ->placeholder('Contoh: 400/12/Desa-2026')
                            ->helperText('Isi jika status disetujui'),
                            
                        // 🌟 JALUR PDF SEKARANG SUDAH DI TEMPAT YANG BENAR (MUNCUL JIKA DISETUJUI)
                        Forms\Components\FileUpload::make('jalur_pdf')
                            ->label('Unggah Surat Resmi (PDF)')
                            ->directory('surat_keluar')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(2048)
                            ->helperText('Unggah surat yang telah ditandatangani dalam format PDF')
                            ->visible(fn (Forms\Get $get) => $get('status') === 'disetujui'),
                            
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('penduduk.nama_lengkap')
                    ->label('Nama Pemohon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenisSurat.nama_surat')
                    ->label('Jenis Surat'),
                
                Tables\Columns\TextColumn::make('bukti_pendukung')
                    ->label('Berkas Persyaratan')
                    ->formatStateUsing(fn ($state) => $state ? count(json_decode($state, true)) . ' File Terlampir' : 'Tidak Ada')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('No. Surat')
                    ->placeholder('Belum diisi'),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'gray',
                        'disetujui' => 'info',
                        'ditolak'   => 'danger',
                        default     => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'disetujui' => 'Disetujui',
                        'ditolak'   => 'Ditolak',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Proses Surat'),
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
}