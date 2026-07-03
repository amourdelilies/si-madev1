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
                        ->relationship('penduduk', 'nama_lengkap') // <-- Disesuaikan dengan kolom asli databasemu
                        ->searchable()
                        ->preload()
                        ->label('Nama Warga / Penerima')
                        ->required(),

                        // 2. Pilih Komoditas Sembako dari Lumbung yang Tersedia
                        Forms\Components\TextInput::make('nama_barang') // <-- Ubah nama kolomnya menjadi string biasa
    ->label('Nama Barang / Jenis Bantuan')
    ->placeholder('Contoh: Beras Bulog 10 Kg, Kursi Roda Pemprov, dll.')
    ->required(),

                        // 3. Jumlah Bantuan yang diberikan
                        Forms\Components\TextInput::make('jumlah_bantuan')
                            ->numeric()
                            ->label('Jumlah / Kuantitas')
                            ->required()
                            ->minValue(1),

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


                            // 1. Tambahkan dropdown Sumber Bantuan setelah memilih barang
Forms\Components\Select::make('sumber_bantuan')
->label('Sumber Bantuan')
->options([
    'Pemerintah Pusat' => 'Pemerintah Pusat (APBN / Bansos)',
    'Pemerintah Daerah' => 'Pemerintah Daerah (APBD)',
    'Dana Desa' => 'Alokasi Dana Desa (ADD)',
    'Swadaya' => 'Swadaya / CSR / Sumbangan',
])
->required()
->searchable(),

// 2. Tambahkan Keterangan Tambahan untuk nomor program pemerintah jika ada
Forms\Components\TextInput::make('keterangan_program')
->label('Nama Program / No. SK')
->placeholder('Contoh: BLT Pangan Tahap II / Bantuan Poktan 2026')
->nullable(),

// 📸 Dokumentasi Pihak Desa
Forms\Components\FileUpload::make('foto_penyerahan_desa')
    ->label('Bukti Penyerahan oleh Perangkat Desa')
    ->disk('public') // 🟢 WAJIB TAMBAHKAN INI
    ->directory('dokumentasi-lumbung/desa')
    ->image()
    ->maxSize(2048)
    ->nullable(),

// 📸 Dokumentasi Pihak Warga
Forms\Components\FileUpload::make('foto_penerimaan_warga')
    ->label('Bukti Penerimaan oleh Warga')
    ->disk('public') // 🟢 WAJIB TAMBAHKAN INI
    ->directory('dokumentasi-lumbung/warga')
    ->image()
    ->maxSize(2048)
    ->nullable(),

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
                Tables\Columns\TextColumn::make('penduduk.nama_lengkap') // <-- Menggunakan nama_lengkap
    ->label('Nama Penerima')
    ->searchable()
    ->sortable(),
    Tables\Columns\TextColumn::make('nama_barang')
    ->label('Nama Barang / Jenis Bantuan')
    ->searchable()
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