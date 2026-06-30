<?php

namespace App\Filament\Resources\BantuanLumbungDesaResource\Pages;

use App\Filament\Resources\BantuanLumbungDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBantuanLumbungDesa extends EditRecord
{
    protected static string $resource = BantuanLumbungDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
