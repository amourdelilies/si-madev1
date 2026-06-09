<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendudukResource\Pages;
use App\Models\Penduduk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PendudukResource extends Resource
{
    protected static ?string $model = Penduduk::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Data Penduduk';
    protected static ?string $pluralModelLabel = 'Data Penduduk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Identitas')->schema([
                    Forms\Components\TextInput::make('nik')
                        ->label('NIK (Nomor Induk Kependudukan)')
                        ->required()
                        ->maxLength(16)
                        ->minLength(16)
                        ->unique(ignoreRecord: true),
                        
                    Forms\Components\TextInput::make('no_kk')
                        ->label('Nomor Kartu Keluarga (KK)')
                        ->required()
                        ->maxLength(16)
                        ->minLength(16),
                        
                    Forms\Components\TextInput::make('nama_lengkap')
                        ->label('Nama Lengkap')
                        ->required(),
                ])->columns(2),

                Forms\Components\Section::make('Data Kelahiran & Profil')->schema([
                    Forms\Components\TextInput::make('tempat_lahir')
                        ->required(),
                        
                    Forms\Components\DatePicker::make('tanggal_lahir')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y'),
                        
                    Forms\Components\Select::make('jenis_kelamin')
                        ->options([
                            'L' => 'Laki-laki',
                            'P' => 'Perempuan',
                        ])
                        ->required()
                        ->native(false),
                        
                    Forms\Components\Select::make('status_perkawinan')
                        ->options([
                            'Belum Kawin' => 'Belum Kawin',
                            'Kawin' => 'Kawin',
                            'Cerai Hidup' => 'Cerai Hidup',
                            'Cerai Mati' => 'Cerai Mati',
                        ])
                        ->required()
                        ->native(false),
                        
                    Forms\Components\TextInput::make('pekerjaan')
                        ->required(),
                        
                    Forms\Components\Toggle::make('is_aktif')
                        ->label('Status Domisili Aktif')
                        ->default(true),
                ])->columns(2),

                Forms\Components\Section::make('Alamat')->schema([
                    Forms\Components\Textarea::make('alamat')
                        ->required()
                        ->placeholder('Tulis alamat lengkap beserta jalan/rt/rw')
                        ->columnSpanFull(),
                ]),

                // 🌟 BAGIAN BARU: Tempat pratinjau berkas digital yang di-upload warga
                Forms\Components\Section::make('Berkas Digital Warga')->schema([
                    Forms\Components\Placeholder::make('foto_preview')
                        ->label('Berkas Foto KTP / KK Warga')
                        ->content(function ($record) {
                            // Jika warga belum mengunggah foto, tampilkan teks peringatan
                            if (! $record || ! $record->foto) {
                                return 'Warga belum mengunggah berkas digital.';
                            }

                            // Generate URL gambar asli dari storage public laptopmu
                            $imageUrl = asset('storage/' . $record->foto);

                            // Menampilkan gambar langsung di halaman admin Filament
                            return new \Illuminate\Support\HtmlString("
                                <div class='mt-2'>
                                    <a href='{$imageUrl}' target='_blank' title='Klik untuk memperbesar gambar'>
                                        <img src='{$imageUrl}' class='max-w-md h-auto rounded-lg shadow-sm border border-gray-200 hover:opacity-90 transition duration-150' />
                                    </a>
                                    <p class='text-xs text-gray-400 mt-2'>💡 Tips: Klik pada gambar untuk melihat ukuran penuh di tab baru.</p>
                                </div>
                            ");
                        })
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 🌟 BAGIAN BARU: Menampilkan thumbnail foto KTP langsung di baris tabel admin
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Berkas')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('JK')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('pekerjaan')
                    ->label('Pekerjaan'),
                Tables\Columns\IconColumn::make('is_aktif')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenduduks::route('/'),
            'create' => Pages\CreatePenduduk::route('/create'),
            'edit' => Pages\EditPenduduk::route('/{record}/edit'),
        ];
    }
}