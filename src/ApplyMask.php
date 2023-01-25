<?php

declare(strict_types=1);

namespace Latte;

final class ApplyMask
{
    public static function custom(string $value, string $format): string
    {
        $mask = '';
        $k = 0;
        for ($i = 0; $i <= strlen($format) - 1; $i++) {
            if ($format[$i] === '#') {
                if (isset($value[$k])) {
                    $mask .= $value[$k++];
                }
            } elseif (isset($format[$i])) {
                $mask .= $format[$i];
            }
        }

        return $mask;
    }
}
