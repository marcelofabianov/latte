<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Latte\ExternalCode;

final class ExternalCodeCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_a($value, ExternalCode::class)) {
            return $value;
        }

        return ExternalCode::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_a($value, ExternalCode::class)) {
            return $value->getValue();
        }

        return ExternalCode::create($value)->getValue();
    }
}
