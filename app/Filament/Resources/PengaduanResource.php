<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaduanResource\Pages;
use App\Filament\Resources\PengaduanResource\RelationManagers;
use App\Models\Pengaduan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'pengaduan';
    
    protected static ?string $navigationLabel = 'Pengaduan Warga';
    protected static ?string $pluralLabel = 'Pengaduan Warga';
    protected static ?string $modelLabel = 'Pengaduan Warga';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Kita bagi form menjadi 2 kolom menggunakan Component Card/Section agar rapi
                Forms\Components\Section::make('Detail Pengaduan Warga')
                    ->description('Informasi lengkap mengenai laporan yang dikirimkan oleh warga.')
                    ->schema([
                        Forms\Components\Select::make('penduduk_id')
                            ->relationship('penduduk', 'nama_lengkap')
                            ->label('Nama Pengadu')
                            ->disabled() 
                            ->placeholder('Memuat nama penduduk...'),

                        Forms\Components\TextInput::make('judul_pengaduan')
                            ->label('Judul Laporan')
                            ->disabled() 
                            ->required(),

                        Forms\Components\TextInput::make('kategori')
                            ->label('Kategori')
                            ->disabled()
                            ->formatStateUsing(fn ($state) => ucfirst($state)),

                        Forms\Components\Textarea::make('deskripsi_pengaduan')
                            ->label('Isi/Deskripsi Laporan')
                            ->rows(5)
                            ->disabled()
                            ->columnSpanFull(), // Biar memanjang penuh ke kanan
                    ])
                    ->columns(2), // Membagi layout section ini menjadi 2 kolom

                Forms\Components\Section::make('Proses & Tindak Lanjut Admin')
                    ->description('Bagian khusus perangkat desa untuk mengubah status dan memberikan tanggapan.')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Pengaduan')
                            ->options([
                                'dikirim' => 'Dikirim (Belum Diproses)',
                                'diproses' => 'Sedang Diproses',
                                'selesai' => 'Selesai (Ditutup)',
                            ])
                            ->required()
                            ->native(false), // Menggunakan UI dropdown Filament yang premium

                      
                        Forms\Components\Textarea::make('tindak_lanjut')
                            ->label('Tindak Lanjut / Tanggapan Admin')
                            ->placeholder('Tuliskan tanggapan resmi atau tindakan yang sudah diambil desa...')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('ditangani_oleh')
                            ->hiddenLabel() 
                            ->content(function (? \App\Models\Pengaduan $record) {
                                if (!$record) {
                                    return new \Illuminate\Support\HtmlString("Terakhir ditangani oleh : <strong>Belum ditangani (Data Baru)</strong>");
                                }
                                $namaAdmin = $record->penanggungJawab?->name ?? 'Belum ditangani (Tidak ada)';
                                // Kita gabungkan Label dan Konten menggunakan tag HTML strong agar tebal
                                return new \Illuminate\Support\HtmlString("Terakhir ditangani oleh : <strong>{$namaAdmin}</strong>");
                            }),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([            
                Tables\Columns\TextColumn::make('penduduk.nama_lengkap')
                    ->label('Nama Warga')
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul_pengaduan')
                    ->label('Judul Laporan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge() // Membuat tampilan kategori berbentuk kapsul/badge warna-warni
                    ->color(fn (string $state): string => match ($state) {
                        'infrastruktur' => 'warning',
                        'kebersihan' => 'success',
                        'pelayanan' => 'info',
                        'keamanan' => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaduans::route('/'),
            'create' => Pages\CreatePengaduan::route('/create'),
            'edit' => Pages\EditPengaduan::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        // Menghitung otomatis pengaduan yang statusnya masih 'pending' atau 'baru'
        // Silakan sesuaikan 'status' dan 'pending' dengan nama kolom & value di database kamu ya!
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    // 🌟 FIX: Mengatur warna badge menjadi merah (danger) agar menarik perhatian admin
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger'; 
    }
}
