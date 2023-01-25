<?php

declare(strict_types=1);

namespace Latte;

final class Email
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

    public function equals(self $other): bool
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

    public static function create(mixed $value): self
    {
        if (! is_string($value) || ! self::isValid($value)) {
            throw new \InvalidArgumentException('Invalid Email!');
        }

        return new self($value);
    }
}
