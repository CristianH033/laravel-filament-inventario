<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Blade;

class RenderBlade
{
    public static function badge(string $color, string $text): string
    {
        return Blade::render('<x-filament::badge color="'.$color.'">'.$text.'</x-filament::badge>');
    }
}
