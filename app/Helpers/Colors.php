<?php

namespace App\Helpers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class Colors
{
    /**
     * Get all colors
     *
     * @return array<string, array<string, string>>
     */
    public static function getAll(): array
    {
        $baseColors = collect(Color::all());
        $filamentColors = collect(FilamentColor::getColors());

        /**
         * @var array<string, array<string, string>>
         */
        return $baseColors->merge($filamentColors)->toArray();
    }

    /**
     * Get all color keys
     *
     * @return array<string>
     */
    public static function getAllKeys(): array
    {
        /**
         * @var array<string>
         */
        return collect(self::getAll())->keys()->toArray();
    }
}
