<?php

declare(strict_types=1);

namespace Latte;

use Latte\Interfaces\GenerateValueObject;

final class Hostname implements GenerateValueObject
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

    public function equals(GenerateValueObject $other): bool
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
