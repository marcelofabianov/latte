<?php

declare(strict_types=1);

namespace Latte\Helpers;

final class NumSanitizer
{
    public static function numericDecimal(string|float|int $num): float|int
    {
        $regex = '/[^0-9.,]/';
        $num = preg_replace($regex, '', $num);

        if (str_contains($num, ',') && str_contains($num, '.')) {
            return (float) str_replace(['.', ','], ['', '.'], $num);
        }

        if (str_contains($num, ',') && str_contains($num, '.') === false) {
            return (float) str_replace(',', '.', $num);
        }

        if (str_contains($num, '.') && str_contains($num, ',') === false) {
            return (float) $num;
        }

        return (int) $num;
    }
}
