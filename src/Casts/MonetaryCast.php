<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Latte\Monetary;

final class MonetaryCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Monetary::class)) {
            return $value;
        }

        return Monetary::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Monetary::class)) {
            return $value->getDecimal();
        }

        return Monetary::create($value)->getDecimal();
    }
}
