<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Helpers\Colors;
use App\Models\Status;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class ItemStatusOverview extends ChartWidget
{
    protected function getData(): array
    {
        $statuses = Status::select('id', 'name', 'color')->withCount('items')->orderBy('id')->get();

        $labels = $statuses->pluck('name');
        $data = $statuses->pluck('items_count');
        $backgroundColors = ($statuses->map(fn ($status) => Colors::rgbaColor($status->color, 700, 0.8)));
        $borderColors = ($statuses->map(fn ($status) => Colors::rgbColor($status->color, 400)));

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

    public function getHeading(): string|Htmlable|null
    {
        return __('Items by Status');
    }
}
