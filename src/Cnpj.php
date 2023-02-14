<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use Latte\Enums\RegistrationDocumentEnum;
use Latte\Interfaces\IRegistrationDocument;

final class Cnpj implements IRegistrationDocument
{
    private readonly string $value;

    private function __construct(string $value)
    {
        $this->value = self::sanitize($value);
    }

    public function numbers(): string
    {
        return self::sanitize($this->value);
    }

    public function format(): string
    {
        return ApplyMask::custom($this->value, '##.###.###/####-##');
    }

    public function equals(IRegistrationDocument $other): bool
    {
        return $this->numbers() === $other->numbers();
    }

    public function __toString(): string
    {
        return $this->numbers();
    }

    public static function isValid(string $value): bool
    {
        $doc = self::sanitize($value);

        if (strlen($doc) != 14 or preg_match('/(\d)\1{13}/', $doc)) {
            return false;
        }

        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $doc[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $remainder = $sum % 11;

        if ($doc[12] != ($remainder < 2 ? 0 : 11 - $remainder)) {
            return false;
        }

        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $doc[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $remainder = $sum % 11;

        return $doc[13] == ($remainder < 2 ? 0 : 11 - $remainder);
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
        $n9 = 0;
        $n10 = 0;
        $n11 = 0;
        $n12 = 1;

        $d1 = $n12 * 2 + $n11 * 3 + $n10 * 4 + $n9 * 5 + $n8 * 6 + $n7 * 7 + $n6 * 8 + $n5 * 9 + $n4 * 2 + $n3 * 3 + $n2 * 4 + $n1 * 5;
        $d1 = 11 - (self::mod($d1));
        if ($d1 >= 10) {
            $d1 = 0;
        }

        $d2 = $d1 * 2 + $n12 * 3 + $n11 * 4 + $n10 * 5 + $n9 * 6 + $n8 * 7 + $n7 * 8 + $n6 * 9 + $n5 * 2 + $n4 * 3 + $n3 * 4 + $n2 * 5 + $n1 * 6;
        $d2 = 11 - (self::mod($d2));
        if ($d2 >= 10) {
            $d2 = 0;
        }

        $result = ''.$n1.$n2.$n3.$n4.$n5.$n6.$n7.$n8.$n9.$n10.$n11.$n12.$d1.$d2;

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

        return new self($value);
    }

    public static function type(): string
    {
        return RegistrationDocumentEnum::CNPJ->value;
    }
}
