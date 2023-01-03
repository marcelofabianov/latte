<?php

declare(strict_types=1);

namespace Latte;

use Latte\Interfaces\ValueObject;
use stdClass;

final class Json implements ValueObject
{
    private readonly array|string $value;

    public function __construct(array|string $value)
    {
        $this->value = $value;
    }

    public function getValue(): array|string
    {
        return $this->value;
    }

    public function equals(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString(): string
    {
        if (is_array($this->value)) {
            return $this->encode();
        }

        return $this->getValue();
    }

    public function encode(): string|bool
    {
        if (is_array($this->value)) {
            return json_encode($this->value, JSON_THROW_ON_ERROR);
        }

        return false;
    }

    public function decode(): stdClass|array|bool
    {
        if (is_string($this->value)) {
            return json_decode($this->value, false, 512, JSON_THROW_ON_ERROR);
        }

        return false;
    }

    public static function create(mixed $value): self
    {
        if (! is_string($value) and ! is_array($value)) {
            throw new \InvalidArgumentException('Unsupported argument type');
        }

        return new self($value);
    }
}
