<?php

declare(strict_types=1);

namespace Latte\Helpers;

final class StrSanitizer
{
    public static function alphanumeric(string $str, bool $keepAccentuation = true): string
    {
        if ($keepAccentuation) {
            $str = str_replace(
                ['á', 'à', 'ã', 'â', 'é', 'ê', 'í', 'ó', 'ô', 'õ', 'ú', 'ç', 'Á', 'À', 'Ã', 'Â', 'É', 'Ê', 'Í', 'Ó', 'Ô', 'Õ', 'Ú', 'Ç'],
                ['a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'c', 'A', 'A', 'A', 'A', 'E', 'E', 'I', 'O', 'O', 'O', 'U', 'C'],
                $str
            );
        }

        $regex = '/[^a-zA-Z0-9]/';

        return preg_replace($regex, '', $str);
    }
}
