<?php

declare(strict_types=1);

namespace Latte\Rules;

use Illuminate\Contracts\Validation\Rule;
use Latte\ExternalCode;

final class ExternalCodeRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return ExternalCode::isValid($value);
    }

    public function message(): string
    {
        return 'The :attribute ExternalCode not is valid';
    }
}
