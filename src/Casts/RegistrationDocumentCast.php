<?php

declare(strict_types=1);

namespace Latte\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Latte\RegistrationDocument;

final class RegistrationDocumentCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_a($value, RegistrationDocument::class)) {
            return $value;
        }

        return RegistrationDocument::create($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_a($value, RegistrationDocument::class)) {
            return $value->numbers();
        }

        return RegistrationDocument::create($value)->numbers();
    }
}
