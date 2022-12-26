<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use Latte\Interfaces\ValueObject;
use Ramsey\Uuid\Uuid;

final class Id implements ValueObject
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

    public static function isValid(string $value): bool
    {
        return Uuid::isValid($value);
    }

    public static function random(): self
    {
        return new self((string) Uuid::uuid4());
    }

    public static function create($value): self
    {
        if (! is_string($value) || ! self::isValid($value)) {
            throw new InvalidArgumentException('Invalid UUID');
        }

        return new self($value);
    }
}
