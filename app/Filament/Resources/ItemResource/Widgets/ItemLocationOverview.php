<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Helpers\Arrays;
use App\Models\Location;
use App\Models\Status;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Widgets\ChartWidget;

class ItemLocationOverview extends ChartWidget
{
    protected static ?string $heading = 'Items by Location';

    protected function getData(): array
    {
        $labels = Location::pluck('name')->toArray();
        $datasets = $this->getDatasets();

        // dd($datasets);

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    public function getDatasets(): array
    {
        $locations = Location::with('items')->get();
        $filamentColors = FilamentColor::getColors();

        $dataSets = [];

        // make a dataset for each status
        Status::each(function ($status, $i) use ($locations, $filamentColors, &$dataSets) {
            $data = $locations->map(function ($location) use ($status) {
                return $location->items->where('status_id', $status->id)->count();
            })->toArray();

            $backgroundColors = collect(range(0, count($locations) - 1))->map(function ($i) use ($filamentColors, $status) {
                return "rgba(" . $filamentColors[$status->color][900] . ", 0.6)";
            })->toArray();

            $borderColors = collect(range(0, count($locations) - 1))->map(function ($i) use ($filamentColors, $status) {
                return "rgb(" . $filamentColors[$status->color][500] . ")";
            })->toArray();

            $dataSets[] = [
                'label' => $status->name,
                'data' => $data,
                'backgroundColor' => $backgroundColors,
                'borderColor' => $borderColors,
                'hoverOffset' => 4,
                "order" => $i + 1,
            ];
        });

        // make a dataset for the total
        $data = $locations->map(function ($location) {
            return $location->items->count();
        })->toArray();

        $dataSets[] = [
            'label' => 'Total',
            'data' => $data,
            'backgroundColor' => "rgba(" . Color::Amber[900] . ", 0.6)",
            'borderColor' => "rgb(" . Color::Amber[500] . ")",
            "fill" => false,
            "pointHoverRadius" => 20,
            "pointHoverBorderWidth" => 5,
            "type" => "line",
            "order" => 0,
        ];

        return $dataSets;
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getOptions(): array
    {
        return [
            'responsive' => true,
            // 'maintainAspectRatio' => false,
            'animation' => [
                'duration' => 500,
                // 'easing' => 'easeInBounce',
            ],
            'title' => [
                'display' => true,
                'text' => 'Bar + Line Chart',
                'fontSize' => 25,
            ],
            'scales' => [
                'x' => [
                    'ticks' => [
                        'display' => false,
                    ],
                    'stacked' => true,

                ],
                'y' => [
                    'ticks' => [
                        'display' => true,
                    ],
                    'stacked' => true,
                ],
                // 'xAxes' => [
                //     'stacked' => true,
                //     'grid' => [
                //         'display' => false,
                //     ],
                //     "title" => [
                //         "display" => false,
                //     ],
                //     "ticks" => [
                //         "display" => false
                //     ],
                // ],
                // 'yAxes' => [
                //     'stacked' => true,
                //     'grid' => [
                //         'display' => false,
                //     ],
                //     "scaleShowLabels" => false,
                //     "ticks" => [
                //         "display" => true
                //     ],
                // ],
            ],
        ];
    }

    public function getColumnSpan(): int | string | array
    {
        return 1;
    }
}
