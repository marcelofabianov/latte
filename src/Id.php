<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class Id
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

    public static function create(string $value): self
    {
        if (! self::isValid($value)) {
            throw new InvalidArgumentException('Invalid UUID');
        }

        return new self($value);
    }
}
