<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use Latte\Enums\RegistrationDocumentEnum;
use Latte\Interfaces\IRegistrationDocument;

final class RegistrationDocument
{
    private readonly IRegistrationDocument $value;

    private function __construct(IRegistrationDocument $value)
    {
        $this->value = $value;
    }

    public function numbers(): string
    {
        return $this->value->numbers();
    }

    public function format(): string
    {
        return $this->value->format();
    }

    public function equals(self $other): bool
    {
        return $this->numbers() === $other->numbers();
    }

    public function __toString(): string
    {
        return $this->numbers();
    }

    public function type(): string
    {
        return $this->value::type();
    }

    public static function random(RegistrationDocumentEnum $type = RegistrationDocumentEnum::CNPJ): self
    {
        if ($type === RegistrationDocumentEnum::CNPJ) {
            return new self(Cnpj::random());
        }
        if ($type === RegistrationDocumentEnum::CPF) {
            return new self(Cpf::random());
        }

        throw new InvalidArgumentException('RegistrationDocumentEnum invalid!');
    }

    public static function valid(string $value): bool
    {
        return Cnpj::isValid($value) or Cpf::isValid($value);
    }

    public static function create(string $value): self
    {
        if (Cnpj::isValid($value)) {
            return new self(Cnpj::create($value));
        }
        if (Cpf::isValid($value)) {
            return new self(Cpf::create($value));
        }

        throw new InvalidArgumentException('RegistrationDocument invalid!');
    }
}
