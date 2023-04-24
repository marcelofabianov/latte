<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Latte\CTeKey;

final class CTeKeyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_a($value, CTeKey::class)) {
            return $value;
        }

        return CTeKey::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_a($value, CTeKey::class)) {
            return $value->numbers();
        }

        return CTeKey::create($value)->numbers();
    }
}
