<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

final class Uuid
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

    public static function isValid(string $value): bool
    {
        return RamseyUuid::isValid($value);
    }

    public static function random(): self
    {
        return new self((string) RamseyUuid::uuid4());
    }

    public static function create(mixed $value): self
    {
        if (! is_string($value) || ! self::isValid($value)) {
            throw new InvalidArgumentException('Invalid UUID');
        }

        return new self($value);
    }
}
