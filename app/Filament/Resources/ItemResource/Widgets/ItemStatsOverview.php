<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Models\Historical;
use App\Models\Item;
use App\Models\Location;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ItemStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Items'), Item::count())
                ->icon('tabler-device-heart-monitor'),
            Stat::make(__('Total Locations'), Location::count())
                ->icon('uiw-map'),
            Stat::make(__('Total Items Changes'), Historical::count())
                ->icon('fluentui-history-20'),
        ];
    }
}
