<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Latte\Uuid;

final class UuidCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Uuid::class)) {
            return $value;
        }

        if (is_null($value)) {
            return null;
        }

        return Uuid::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Uuid::class)) {
            return $value->getValue();
        }

        if (is_null($value)) {
            return null;
        }

        return Uuid::create($value)->getValue();
    }
}
