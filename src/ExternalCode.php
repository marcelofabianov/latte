<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class ExternalCode
{
    private readonly string|int $value;

    private function __construct(string|int $value)
    {
        $this->value = $value;
    }

    public function getValue(): string|int
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString(): string
    {
        return (string) $this->getValue();
    }

    public static function isValid($value): bool
    {
        $numeric = (int) $value;

        if ($numeric > 0) {
            return true;
        }

        if (is_string($value) and Uuid::isValid($value)) {
            return true;
        }

        return is_int($value) && $value > 0;
    }

    public static function random(): self
    {
        return new self((string) Uuid::uuid4());
    }

    public static function create(mixed $value): self
    {
        if (! self::isValid($value)) {
            throw new InvalidArgumentException($value);
        }

        return new self($value);
    }
}
