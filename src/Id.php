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

    public function equals(self|ValueObject $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString()
    {
        return $this->value;
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
