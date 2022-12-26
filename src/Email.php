<?php

declare(strict_types=1);

namespace Latte;

use Latte\Interfaces\ValueObject;

final class Email implements ValueObject
{
    private readonly string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public static function isValid(string $email): bool
    {
        if (filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public static function create($value): ValueObject
    {
        if (! is_string($value) || ! self::isValid($value)) {
            throw new \InvalidArgumentException('Invalid Email!');
        }

        return new self($value);
    }
}
