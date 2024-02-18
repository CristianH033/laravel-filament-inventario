<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use App\Models\Category;
use App\Models\Item;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ItemCategoryOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Items', Item::count()),
            Stat::make('Total Categories', Category::count()),
        ];
    }
}
