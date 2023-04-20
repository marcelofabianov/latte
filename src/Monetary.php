<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use JsonSerializable;
use stdClass;

final class Monetary implements JsonSerializable
{
    private readonly float $value;

    private readonly string $currency;

    public function __construct(float $value, string $currency)
    {
        $this->value = (float) number_format($value, 2, '.', '');
        $this->currency = $currency;
    }

    public function getFormat(string $decimalSeparator = ',', string $thousandsSeparator = '.'): string
    {
        return number_format($this->value, 2, $decimalSeparator, $thousandsSeparator);
    }

    public function getDecimal(): string
    {
        return number_format($this->value, 2, '.', '');
    }

    public function getValue(): float
    {
        return (float) $this->getDecimal();
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
            'value' => $this->getValue(),
            'currency' => $this->currency,
        ];
    }

    public function toEquals(self $money): bool
    {
        return $this->value === $money->getValue() and $this->currency === $money->getCurrency();
    }

    public static function random(float $min = 0.1, float $max = 10.1, string $currency = 'BRL'): self
    {
        return new self(
            value: $min + mt_rand() / mt_getrandmax() * ($max - $min),
            currency: $currency,
        );
    }

    public static function create(float|string|int|stdClass $value, string $currency = 'BRL'): self
    {
        // {value: 1000, currency: 'BRL'}
        if ($value instanceof stdClass) {
            if (! isset($value->value) && ! isset($value->currency)) {
                throw new InvalidArgumentException('Invalid object');
            }
            $currency = is_string($value->currency) ? $value->currency : $currency;
            $value = (float) $value->value;
        }

        // 1.000,00
        if (is_string($value) && str_contains($value, ',') && str_contains($value, '.')) {
            $value = str_replace(['.', ','], ['', '.'], $value);
        }
        // 1000,00
        if (is_string($value) && str_contains($value, ',') && str_contains($value, '.') === false) {
            $value = str_replace(',', '.', $value);
        }

        if (is_int($value) && $value === 0) {
            $value = 0.00;
        }

        try {
            $monetary = new self((float) $value, $currency);
        } catch (InvalidArgumentException) {
            throw new InvalidArgumentException('Invalid monetary value');
        }

        return $monetary;
    }
}
