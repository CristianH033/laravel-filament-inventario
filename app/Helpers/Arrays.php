<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Arrays
{
    /**
     * Map an array to a set of keys
     *
     * @param  array<string|int>  $sourceArray
     * @param  array<string|int>  $keysArray
     * @return array<string|int|null>
     */
    public static function mapArrayToKeys(array $sourceArray, array $keysArray): array
    {

        $strSalt = '_zyx_xyz_';

        $sourceArrayCount = count($sourceArray);

        if ($sourceArrayCount === 0) {
            return array_fill_keys($keysArray, null);
        }

        $result = collect([]);

        collect($keysArray)->chunk($sourceArrayCount)->each(function ($chunk) use (&$result, $sourceArray, $strSalt) {
            $processedChunk = $chunk->combine(collect($sourceArray)->take($chunk->count()));

            // transform int keys to string keys
            $processedChunk = $processedChunk->mapWithKeys(fn ($value, $key) => [Str::of($key)->append($strSalt)->value() => $value]);

            $result = $result->merge($processedChunk);
        });

        $result = $result->mapWithKeys(
            fn ($value, $key) => [Str::of($key)->replace($strSalt, '')->value() => $value]
        )->toArray();

        /**
         * @var array<string|int|null> $result
         */
        return (array) $result;
    }
}
