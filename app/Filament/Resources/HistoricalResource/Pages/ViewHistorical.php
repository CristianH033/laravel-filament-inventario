<?php

namespace App\Filament\Resources\HistoricalResource\Pages;

use App\Filament\Resources\HistoricalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHistorical extends ViewRecord
{
    protected static string $resource = HistoricalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
