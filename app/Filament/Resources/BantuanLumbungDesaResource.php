<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanLumbungDesaResource\Pages;
use App\Models\BantuanLumbungDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class BantuanLumbungDesaResource extends Resource
{
    protected static ?string $model = BantuanLumbungDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationLabel = 'Bantuan Lumbung Desa';
    protected static ?string $pluralLabel = 'Bantuan Lumbung Desa';
    protected static ?string $modelLabel = 'Bantuan Lumbung';
    protected static ?string $navigationGroup = 'Lumbung Desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        // 1. Pilih Warga Penerima (Bisa cari berdasarkan Nama/NIK)
                        Forms\Components\Select::make('penduduk_id')
                            ->relationship('penduduk', 'nama')
                            ->searchable()
                            ->preload()
                            ->label('Nama Warga / Penerima')
                            ->required(),

                        // 2. Pilih Komoditas Sembako dari Lumbung yang Tersedia
                        Forms\Components\Select::make('lumbung_desa_id')
                            ->relationship('lumbungDesa', 'nama_barang')
                            ->label('Komoditas Pangan')
                            ->required(),

                        // 3. Jumlah Bantuan yang diberikan
                        Forms\Components\TextInput::make('jumlah_bantuan')
                            ->numeric()
                            ->label('Jumlah / Kuantitas')
                            ->required()
                            ->minReturnValue(1),

                        // 4. Keterangan atau Alasan Alokasi
                        Forms\Components\Textarea::make('alasan_keperluan')
                            ->label('Alasan / Keterangan Distribusi')
                            ->placeholder('Contoh: Distribusi sembako langsung untuk lansia kurang mampu di Banjar X')
                            ->required(),

                        // 5. Status Langsung Disalurkan (Karena diinput langsung oleh Admin)
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending (Pengajuan Warga)',
                                'disetujui' => 'Disetujui',
                                'disalurkan' => 'Sudah Disalurkan',
                                'ditolak' => 'Ditolak',
                            ])
                            ->default('disalurkan') // Set default disalurkan jika diinput admin
                            ->required(),

                        // Hidden Input untuk menandai bahwa ini inputan Top-Down dari Admin
                        Forms\Components\Hidden::make('sumber_input')
                            ->default('admin'),

                        // Hidden Input untuk mencatat ID Admin yang sedang login
                        Forms\Components\Hidden::make('diproses_oleh')
                            ->default(fn () => Auth::id()),

                        // Hidden Input untuk mencatat waktu penyaluran otomatis
                        Forms\Components\Hidden::make('disalurkan_pada')
                            ->default(fn () => now()),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penduduk.nama')
                    ->label('Nama Penerima')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lumbungDesa.nama_barang')
                    ->label('Komoditas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_bantuan')
                    ->label('Jumlah')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('sumber_input')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'success', // Hijau untuk Top-Down dari Admin
                        'warga' => 'info',    // Biru untuk Bottom-Up dari Warga
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'disetujui' => 'primary',
                        'disalurkan' => 'success',
                        'ditolak' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Filter berdasarkan metode input (Top-down vs Bottom-up)
                Tables\Filters\SelectFilter::make('sumber_input')
                    ->options([
                        'admin' => 'Distribusi Admin (Top-Down)',
                        'warga' => 'Pengajuan Warga (Bottom-Up)',
                    ])
                    ->label('Metode Distribusi'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanLumbungDesas::route('/'),
            'create' => Pages\CreateBantuanLumbungDesa::route('/create'),
            'edit' => Pages\EditBantuanLumbungDesa::route('/{record}/edit'),
        ];
    }
}