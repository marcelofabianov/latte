<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Latte\Json;

final class JsonCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Json::class)) {
            return $value;
        }

        if (is_null($value)) {
            return null;
        }

        if (! is_array($value) and ! is_string($value)) {
            throw new InvalidArgumentException('Argument type not support');
        }

        return Json::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Json::class)) {
            return $value->encode();
        }

        if (is_null($value)) {
            return null;
        }

        if (! is_array($value) and ! is_string($value)) {
            throw new InvalidArgumentException('Argument type not support');
        }

        return Json::create($value);
    }
}
