<?php

namespace App\Helpers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class Colors
{
    /**
     * Get all colors
     *
     * @return array<string, array<int, string>>
     */
    public static function getAll(): array
    {
        $baseColors = collect(Color::all());
        $filamentColors = collect(FilamentColor::getColors());

        /**
         * @var array<string, array<int, string>>
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

    public static function rgbColor(string $color, int $shade = 500): string
    {
        $colors = self::getAll();

        return 'rgb('.$colors[$color][$shade].')';
    }

    public static function rgbaColor(string $color, int $shade = 500, float $alpha = 0.8): string
    {
        $colors = self::getAll();

        return 'rgba('.$colors[$color][$shade].', '.$alpha.')';
    }
}
