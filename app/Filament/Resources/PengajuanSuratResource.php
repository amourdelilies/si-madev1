<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajuanSuratResource\Pages;
use App\Models\PengajuanSurat;
use App\Enums\StatusSurat;
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
                Forms\Components\Group::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Select::make('penduduk_id')
                            ->relationship('penduduk', 'nama_lengkap')
                            ->disabled() // Supaya admin tidak bisa mengubah siapa pemohonnya
                            ->required(),
                            
                        Forms\Components\Select::make('jenis_surat_id')
                            ->relationship('jenisSurat', 'nama_surat')
                            ->disabled()
                            ->required(),
                            
                        Forms\Components\Textarea::make('keperluan')
                            ->disabled()
                            ->columnSpanFull(),
                    ])->columns(2),
                ])->columnSpan(2),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending (Menunggu)',
                                'diproses' => 'Sedang Diproses',
                                'disetujui' => 'Disetujui (Siap Cetak)',
                                'ditolak' => 'Ditolak',
                                'selesai' => 'Selesai (Sudah Diunduh)',
                            ])
                            ->required()
                            ->native(false),
                            
                        Forms\Components\TextInput::make('nomor_surat')
                            ->placeholder('Contoh: 400/12/Desa-2026')
                            ->helperText('Isi jika status disetujui'),
                            
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
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('No. Surat')
                    ->placeholder('Belum diisi'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'diproses' => 'warning',
                        'disetujui' => 'info',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'diproses' => 'Diproses',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Proses Surat'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajuanSurats::route('/'),
            'create' => Pages\CreatePengajuanSurat::route('/create'),
            'edit' => Pages\EditPengajuanSurat::route('/{record}/edit'),
        ];
    }
}