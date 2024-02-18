<?php

namespace App\Helpers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class Colors
{
    public static function getAll(): array
    {
        $baseColors = collect(Color::all());
        $filamentColors = collect(FilamentColor::getColors());

        return $baseColors->merge($filamentColors)->toArray();
    }

    public static function getAllKeys(): array
    {
        return collect(self::getAll())->keys()->toArray();
    }
}
