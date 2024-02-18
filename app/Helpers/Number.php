<?php

namespace App\Helpers;

class Number
{
    public static function roundUp(float|int $number, int $precision = 0): float
    {
        $fig = (int) str_pad('1', $precision, '0');

        return ceil($number * $fig) / $fig;
    }

    public static function roundUpInt(float|int $number): int
    {
        return (int) ceil($number);
    }

    public function roundDown(float|int $number, int $precision = 2): float
    {
        $fig = (int) str_pad('1', $precision, '0');

        return floor($number * $fig) / $fig;
    }

    public function roundDownInt(float|int $number): int
    {
        return (int) floor($number);
    }
}
