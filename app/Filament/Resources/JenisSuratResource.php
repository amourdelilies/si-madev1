<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisSuratResource\Pages;
use App\Models\JenisSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class JenisSuratResource extends Resource
{
    protected static ?string $model = JenisSurat::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationLabel = 'Jenis Surat';
    protected static ?string $pluralModelLabel = 'Jenis Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('nama_surat')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $state, Forms\Set $set) => $set('slug', Str::slug($state))),
                    
                    Forms\Components\TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required(),
                        
                    Forms\Components\Textarea::make('deskripsi')
                        ->required()
                        ->columnSpanFull(),
                        
                    Forms\Components\TagsInput::make('persyaratan')
                        ->placeholder('Tambah syarat, lalu tekan Enter')
                        ->helperText('Contoh: KTP, Kartu Keluarga, Foto Usaha')
                        ->required(),
                        
                    Forms\Components\TextInput::make('jalur_templat')
                        ->label('Nama Template Blade PDF')
                        ->placeholder('contoh: domisili')
                        ->required(),
                        
                    Forms\Components\Toggle::make('is_aktif')
                        ->label('Aktifkan Surat Ini')
                        ->default(true),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_surat')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('persyaratan')
                    ->badge()
                    ->separator(','),
                Tables\Columns\IconColumn::make('is_aktif')->boolean()->label('Status Aktif'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJenisSurats::route('/'),
            'create' => Pages\CreateJenisSurat::route('/create'),
            'edit' => Pages\EditJenisSurat::route('/{record}/edit'),
        ];
    }
}