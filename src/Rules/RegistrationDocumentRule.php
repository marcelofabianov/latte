<?php

declare(strict_types=1);

namespace Latte\Rules;

use Illuminate\Contracts\Validation\Rule;
use Latte\RegistrationDocument;

final class RegistrationDocumentRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return RegistrationDocument::valid($value);
    }

    public function message(): string
    {
        return 'The :attribute CNPJ/CPF not is valid';
    }
}
