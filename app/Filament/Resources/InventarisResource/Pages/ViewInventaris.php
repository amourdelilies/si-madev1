<?php

namespace App\Filament\Resources\InventarisResource\Pages;

use App\Filament\Resources\InventarisResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInventaris extends ViewRecord
{
    protected static string $resource = InventarisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            
            // 🖨️ Tombol Cetak Label Fisik Terintegrasi Route PDF kita
            Actions\Action::make('print_label')
                ->label('Cetak Label Fisik')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn () => route('inventaris.print-single', $this->record->id))
                ->openUrlInNewTab(),
        ];
    }
}