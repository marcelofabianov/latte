<?php

declare(strict_types=1);

namespace Latte;

use JsonSerializable;

final class Monetary implements JsonSerializable
{
    private readonly float $value;

    private readonly string $currency;

    public function __construct(float $value, string $currency)
    {
        $this->value = $value;
        $this->currency = $currency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->value, $this->currency);
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
            'currency' => $this->currency,
        ];
    }

    public function toEquals(self $money): bool
    {
        return $this->value === $money->getValue() and $this->currency === $money->getCurrency();
    }

    public static function create(float|string|int $value, string $currency = 'BRL'): self
    {
        return new self((float) $value, $currency);
    }
}
