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
    
    // 🌟 FIX ROUTE NOT FOUND: Mengunci nama rute agar Laravel mengenali 'penduduks.index'
    protected static ?string $slug = 'penduduks';

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

               // 🌟 FIX: Hanya memunculkan tombol aksi tanpa langsung menampilkan gambar di halaman
               Forms\Components\Section::make('Berkas Digital Warga')->schema([
                Forms\Components\Placeholder::make('foto_preview')
                    ->label('Aksi Berkas Dokumen Warga')
                    ->content(function ($record) {
                        if (! $record || (! $record->foto_ktp && ! $record->foto_kk)) {
                            return 'Warga belum mengunggah berkas digital.';
                        }

                        $ktpUrl = $record->foto_ktp ? asset('storage/' . $record->foto_ktp) : null;
                        $kkUrl = $record->foto_kk ? asset('storage/' . $record->foto_kk) : null;

                        $htmlOutput = "<div class='flex flex-col space-y-4 mt-2'>";

                        // --- TOMBOL UNTUK KTP ---
                        if ($ktpUrl) {
                            $htmlOutput .= "
                                <div class='flex items-center justify-between border border-gray-200 p-3 rounded-xl bg-gray-50/50 shadow-sm'>
                                    <div class='flex items-center space-x-2'>
                                        <span class='text-base'></span>
                                        <span class='text-sm font-medium text-gray-700'>Dokumen Foto KTP</span>
                                    </div>
                                    <div class='flex gap-2'>
                                        <!-- Tombol Lihat dengan Icon Mata -->
                                        <a href='{$ktpUrl}' target='_blank' class='inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm gap-1.5'>
                                            <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor'>
                                                <path stroke-linecap='round' stroke-linejoin='round' d='M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' />
                                                <path stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' />
                                            </svg>
                                            Lihat
                                        </a>
                                        <!-- Tombol Unduh dengan Icon Download Arrow -->
                                        <a href='{$ktpUrl}' download class='inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm gap-1.5'>
                                            <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor'>
                                                <path stroke-linecap='round' stroke-linejoin='round' d='M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3' />
                                            </svg>
                                            Unduh
                                        </a>
                                    </div>
                                </div>";
                        }

                        // --- TOMBOL UNTUK KK ---
                        if ($kkUrl) {
                            $htmlOutput .= "
                                <div class='flex items-center justify-between border border-gray-200 p-3 rounded-xl bg-gray-50/50 shadow-sm'>
                                    <div class='flex items-center space-x-2'>
                                        <span class='text-base'></span>
                                        <span class='text-sm font-medium text-gray-700'>Dokumen Kartu Keluarga (KK)</span>
                                    </div>
                                    <div class='flex gap-2'>
                                        <!-- Tombol Lihat dengan Icon Mata -->
                                        <a href='{$kkUrl}' target='_blank' class='inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm gap-1.5'>
                                            <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor'>
                                                <path stroke-linecap='round' stroke-linejoin='round' d='M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z' />
                                                <path stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z' />
                                            </svg>
                                            Lihat
                                        </a>
                                        <!-- Tombol Unduh dengan Icon Download Arrow -->
                                        <a href='{$kkUrl}' download class='inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm gap-1.5'>
                                            <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor'>
                                                <path stroke-linecap='round' stroke-linejoin='round' d='M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3' />
                                            </svg>
                                            Unduh
                                        </a>
                                    </div>
                                </div>";
                        }

                        $htmlOutput .= "</div>";
                        return new \Illuminate\Support\HtmlString($htmlOutput);
                    })
                    ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 🌟 FIX FOTO TABEL: Membaca kolom foto_ktp untuk pratinjau lingkaran kecil di tabel admin
            
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