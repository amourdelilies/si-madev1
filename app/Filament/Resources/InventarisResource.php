<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarisResource\Pages\ListInventaris;
use App\Filament\Resources\InventarisResource\Pages\CreateInventaris;
use App\Filament\Resources\InventarisResource\Pages\ViewInventaris;
use App\Filament\Resources\InventarisResource\Pages\EditInventaris;
use App\Models\Inventaris;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class InventarisResource extends Resource
{
    protected static ?string $model = Inventaris::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Inventaris Desa';
    protected static ?string $slug = 'inventaris-desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('📌 Identitas & Spesifikasi Aset')
                    ->schema([
                        Forms\Components\TextInput::make('kode_barang')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: INV/UNUD/2026/001')
                            ->label('Kode Inventaris (Unik)'),
                        Forms\Components\TextInput::make('nama_barang')
                            ->required()
                            ->label('Nama Barang'),
                        Forms\Components\TextInput::make('kategori')
                            ->required()
                            ->label('Kategori'),
                        Forms\Components\TextInput::make('merek_spesifikasi')
                            ->label('Merek / Spesifikasi (Opsional)'),
                    ])->columns(2),

                Forms\Components\Section::make('📊 Manajemen Kuantitas & Lokasi')
                    ->schema([
                        Forms\Components\TextInput::make('jumlah')
                            ->numeric()
                            ->required()
                            ->label('Jumlah / Volume Unit'),
                        Forms\Components\Select::make('kondisi')
                            ->options([
                                'baik' => 'Baik / Layak Pakai',
                                'rusak_ringan' => 'Rusak Ringan',
                                'rusak_berat' => 'Rusak Berat',
                            ])->required()->label('Kondisi Barang'),
                        Forms\Components\TextInput::make('lokasi')
                            ->required()
                            ->label('Lokasi Penyimpanan'),
                    ])->columns(3),

                Forms\Components\Section::make('🔒 Manajemen Pengadaan & Penanggung Jawab')
                    ->schema([
                        Forms\Components\TextInput::make('penanggung_jawab')
                            ->required()
                            ->label('Penanggung Jawab Aset'),
                        Forms\Components\TextInput::make('sumber_perolehan')
                            ->required()
                            ->label('Sumber Perolehan'),
                        Forms\Components\DatePicker::make('tanggal_pengadaan')
                            ->required()
                            ->label('Tanggal Pengadaan'),
                        Forms\Components\FileUpload::make('foto_barang')
                            ->image()
                            ->directory('inventaris-images')
                            ->label('Foto Fisik Barang'),
                        Forms\Components\Textarea::make('catatan')
                            ->columnSpanFull()
                            ->label('Catatan Tambahan'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_barang')->circular()->label('Fisik'),
                Tables\Columns\TextColumn::make('kode_barang')->searchable()->label('Kode'),
                Tables\Columns\TextColumn::make('nama_barang')->searchable()->label('Nama'),
                Tables\Columns\TextColumn::make('kategori')->badge()->color('warning'),
                Tables\Columns\TextColumn::make('jumlah')->alignCenter()->label('Jumlah'),
                Tables\Columns\TextColumn::make('kondisi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'baik' => 'success',
                        'rusak_ringan' => 'warning',
                        'rusak_berat' => 'danger',
                        default => 'gray'
                    })->label('Kondisi'),
                Tables\Columns\TextColumn::make('lokasi')->label('Lokasi'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kondisi')
                    ->options([
                        'baik' => 'Baik / Layak Pakai',
                        'rusak_ringan' => 'Rusak Ringan',
                        'rusak_berat' => 'Rusak Berat',
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    // 🖨️ BULK PRINT ACTION
                    Tables\Actions\BulkAction::make('cetak_label_massal')
                        ->label('Cetak Label Pilihan')
                        ->icon('heroicon-o-printer')
                        ->color('warning')
                        ->action(fn (Collection $records) => redirect()->route('inventaris.print-bulk', ['ids' => $records->pluck('id')->toArray()])),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventaris::route('/'),
            'create' => CreateInventaris::route('/create'),
            'view' => ViewInventaris::route('/{record}'),
            'edit' => EditInventaris::route('/{record}/edit'),
        ];
    }
}