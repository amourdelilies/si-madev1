<?php

namespace App\Filament\Resources\BantuanLumbungDesaResource\Pages;

use App\Filament\Resources\BantuanLumbungDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBantuanLumbungDesas extends ListRecords
{
    protected static string $resource = BantuanLumbungDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
