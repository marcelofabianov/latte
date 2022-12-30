<?php

declare(strict_types=1);

namespace Latte;

final class Hostname
{
    private readonly string $value;

    public function __construct(string $value)
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

    public static function create(): self
    {
        $hostname = gethostname();

        if (! $hostname) {
            throw new \RuntimeException('Invalid Hostname');
        }

        return new self($hostname);
    }
}
