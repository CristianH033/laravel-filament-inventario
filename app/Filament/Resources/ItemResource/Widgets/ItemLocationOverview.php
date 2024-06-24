<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Helpers\Colors;
use App\Models\Location;
use App\Models\Status;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class ItemLocationOverview extends ChartWidget
{
    protected function getData(): array
    {

        [$labels, $datasets] = $this->getChartData();

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    /**
     * Get the datasets for the chart.
     *
     * @return array<array<string, mixed>>
     */
    public function getChartData(): array
    {
        $locations = Location::with('items')->orderBy('id')->get();
        $statuses = Status::orderBy('id')->get();

        $dataSets = [];

        // make a dataset for each status
        $statuses->each(function ($status, $i) use ($locations, &$dataSets) {
            $data = $locations->map(
                fn ($location) => (
                    $location->items->where('status_id', $status->id)->count()
                )
            )->toArray();

            $backgroundColors = $locations->map(fn () => (
                Colors::rgbaColor($status->color, 700, 0.8)
            ))->toArray();

            $borderColors = $locations->map(fn () => (
                Colors::rgbColor($status->color, 400)
            ))->toArray();

            $dataSets[] = [
                'label' => $status->name,
                'data' => $data,
                'backgroundColor' => $backgroundColors,
                'borderColor' => $borderColors,
                'hoverOffset' => 4,
                'order' => $i + 1,
            ];
        });

        // make a dataset for the total
        $dataSetTotal = $locations->map(fn ($location) => (
            $location->items->count()
        ))->toArray();

        $dataSets[] = [
            'label' => 'Total',
            'data' => $dataSetTotal,
            'backgroundColor' => 'rgba(' . Color::Amber[900] . ', 0.6)',
            'borderColor' => 'rgb(' . Color::Amber[500] . ')',
            'fill' => false,
            'pointHoverRadius' => 20,
            'pointHoverBorderWidth' => 5,
            'type' => 'line',
            'order' => 0,
        ];

        $data = [
            $locations->pluck('name')->toArray(),
            $dataSets,
        ];

        return $data;
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
        return 1;
    }

    public function getHeading(): string|Htmlable|null
    {
        return __('Items by Location');
    }
}
