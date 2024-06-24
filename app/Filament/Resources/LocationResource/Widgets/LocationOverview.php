<?php

namespace App\Filament\Resources\LocationResource\Widgets;

use App\Helpers\Colors;
use App\Models\Category;
use App\Models\Location;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Fluent;

class LocationOverview extends ChartWidget
{
    public ?Location $record = null;
    // protected static ?string $heading = 'Distribución de dispositivos';

    protected static ?string $maxHeight = '70dvh';

    public function getHeading(): string
    {
        return 'Distribución de dispositivos en ' . $this->record->name;
    }

    protected function getData(): array
    {
        [$labels, $datasets] = $this->getChartData();

        // dd($labels, $datasets);

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    protected function getChartData(): array
    {
        $data = $this->record->itemsByDeviceCategory();

        $labels = $data->pluck('name')->toArray();

        $statuses = $data->map(function ($category) {
            return $category->statuses;
        })->flatten()->groupBy('id')->map(function ($item) {
            return new Fluent([
                'id' => $item->first()->id,
                'name' => $item->first()->name,
                'color' => $item->first()->color,
                'data' => $item->map(function ($itemData) {
                    return $itemData->items_count;
                })->toArray()
            ]);
        })->values();

        $datasets = $statuses->map(function ($status, $index) {
            return [
                'label' => $status->name,
                'data' => $status->data,
                'backgroundColor' => collect($status->data)->map(fn () => (
                    Colors::rgbaColor($status->color, 700, 0.8)
                ))->toArray(),
                'borderColor' => collect($status->data)->map(fn () => (
                    Colors::rgbColor($status->color, 400)
                ))->toArray(),
                'hoverOffset' => 4,
                'borderWidth' => 1,
                'order' => $index,
            ];
        })->toArray();

        return [$labels, $datasets];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * Get the options for the chart.
     *
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true,
            'aspectRatio' => 1,
            'animation' => [
                'duration' => 500,
            ],
            'title' => [
                'display' => true,
                'text' => 'Bar + Line Chart',
                'fontSize' => 25,
            ],
            'scales' => [
                'x' => [
                    'ticks' => [
                        'display' => true,
                    ],
                    'stacked' => true,

                ],
                'y' => [
                    'ticks' => [
                        'display' => true,
                    ],
                    'stacked' => true,
                ],
            ],
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 2;
    }
}
