<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Latte\Email;

final class EmailCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Email::class)) {
            return $value;
        }

        return Email::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_a($value, Email::class)) {
            return $value->getValue();
        }

        return Email::create($value)->getValue();
    }
}
