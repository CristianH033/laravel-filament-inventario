<?php

namespace App\Filament\Resources\HistoricalResource\Pages;

use App\Filament\Resources\HistoricalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistorical extends EditRecord
{
    protected static string $resource = HistoricalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
