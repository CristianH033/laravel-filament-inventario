<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Models\Status;
use Filament\Support\Facades\FilamentColor;
use Filament\Widgets\ChartWidget;

class ItemStatusOverview extends ChartWidget
{
    protected static ?string $heading = 'Items Overview by Status';

    protected function getData(): array
    {
        $labels = Status::pluck('name')->toArray();
        $data = Status::withCount('items')->get()->pluck('items_count')->toArray();
        $filamentColors = FilamentColor::getColors();
        $backgroundColors = (Status::pluck('color')->map(fn ($color) => 'rgba(' . $filamentColors[$color][700] . ', 0.8)'));
        $borderColors = (Status::pluck('color')->map(fn ($color) => 'rgb(' . $filamentColors[$color][400] . ')'));

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

    /**
     * Get the options for the chart.
     *
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return [
            'animation' => [
                'duration' => 500,
            ],
        ];
    }
}
