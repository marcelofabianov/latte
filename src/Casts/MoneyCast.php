<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Latte\Money;

final class MoneyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Money::class)) {
            return $value;
        }

        return Money::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Money::class)) {
            return $value->getValue();
        }

        return Money::create($value)->getValue();
    }
}
