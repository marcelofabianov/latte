<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Latte\NFeKey;

final class NFeKeyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_a($value, NFeKey::class)) {
            return $value;
        }

        return NFeKey::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_a($value, NFeKey::class)) {
            return $value->getValue();
        }

        return NFeKey::create($value)->getValue();
    }
}
