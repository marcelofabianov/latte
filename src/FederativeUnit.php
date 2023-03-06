<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;

final class FederativeUnit
{
    private static array $cases = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
    ];

    private readonly string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function isValid(string $value): bool
    {
        return array_key_exists($value, self::$cases);
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

    public function display(): string
    {
        return self::$cases[$this->value];
    }

    public function initials(): string
    {
        return $this->value;
    }

    public static function random(): self
    {
        $keys = array_keys(self::$cases);
        $selected = $keys[random_int(0, count($keys))];

        return new self($selected);
    }

    public static function create(mixed $value): self
    {
        if (! is_string($value)) {
            throw new InvalidArgumentException('Unsupported argument type');
        }

        if (! self::isValid($value)) {
            throw new InvalidArgumentException('FederativeUnit invalid!');
        }

        return new self($value);
    }
}
