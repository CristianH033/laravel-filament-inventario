<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Models\Status;
use Filament\Widgets\ChartWidget;
use Filament\Support\Facades\FilamentColor;

class ItemOverview extends ChartWidget
{
    protected static ?string $heading = 'Items Overview';

    protected function getData(): array
    {
        $labels = Status::pluck('name')->toArray();
        $data = Status::withCount('items')->get()->pluck('items_count')->toArray();
        $filamentColors = FilamentColor::getColors();
        $backgroundColors = (Status::pluck('color')->map(fn ($color) => "rgba(" . $filamentColors[$color][900] . ", 0.6)"));
        $borderColors = (Status::pluck('color')->map(fn ($color) => "rgb(" . $filamentColors[$color][500] . ")"));

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Items by Status',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $borderColors,
                    'hoverOffset' => 4,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
