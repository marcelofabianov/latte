<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use Latte\Enums\RegistrationDocumentEnum;
use Latte\Helpers\ApplyMask;
use Latte\Interfaces\IRegistrationDocument;

final class Cpf implements IRegistrationDocument
{
    private readonly string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function numbers(): string
    {
        return self::sanitize($this->value);
    }

    public function format(): string
    {
        return ApplyMask::custom($this->value, '###.###.###-##');
    }

    public function root(): string|null
    {
        return null;
    }

    public function equals(IRegistrationDocument $other): bool
    {
        return $this->numbers() === $other->numbers();
    }

    public function __toString(): string
    {
        return $this->numbers();
    }

    public function isMatrix(): bool
    {
        return false;
    }

    public function prefixMatrix(): string|null
    {
        return null;
    }

    public static function isValid(string $value): bool
    {
        $doc = self::sanitize($value);

        if (strlen($doc) != 11 or preg_match('/(\d)\1{10}/', $doc)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $doc[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($doc[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    private static function mod(int|float $dividend): float
    {
        return round($dividend - (floor($dividend / 11) * 11));
    }

    public static function random(): self
    {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = rand(0, 9);
        $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
        $d1 = 11 - (self::mod($d1));
        if ($d1 >= 10) {
            $d1 = 0;
        }
        $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
        $d2 = 11 - (self::mod($d2));
        if ($d2 >= 10) {
            $d2 = 0;
        }
        $result = ''.$n1.$n2.$n3.$n4.$n5.$n6.$n7.$n8.$n9.$d1.$d2;

        return new self($result);
    }

    public static function sanitize(string $value): string
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    public static function create(string $value): self
    {
        if (! self::isValid($value)) {
            throw new InvalidArgumentException(self::type());
        }

        return new self(self::sanitize($value));
    }

    public static function type(): string
    {
        return RegistrationDocumentEnum::CPF->value;
    }
}
