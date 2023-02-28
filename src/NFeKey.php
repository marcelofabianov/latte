<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;

final class NFeKey
{
    private readonly array $value;

    private static int $characterLimit = 44;

    private static array $characterPosition = [
        'cUF' => [0, 2],
        'YYMM' => [2, 4],
        'emitter' => [6, 14],
        'model' => [20, 2],
        'series' => [22, 3],
        'numbers' => [25, 9],
        'typeEmission' => [34, 1],
        'codeNumeric' => [35, 8],
        'dv' => [43, 1],
    ];

    private static array $federativeUnitCodes = [
        // Norte
        11 => 'Rondônia',
        12 => 'Acre',
        13 => 'Amazonas',
        14 => 'Roraima',
        15 => 'Pará',
        16 => 'Amapá',
        17 => 'Tocantins',
        // Nordeste
        21 => 'Maranhão',
        22 => 'Piauí',
        23 => 'Ceará',
        24 => 'Rio Grande do Norte',
        25 => 'Paraíba',
        26 => 'Pernambuco',
        27 => 'Alagoas',
        28 => 'Sergipe',
        29 => 'Bahia',
        // Sudeste
        31 => 'Minas Gerais',
        32 => 'Espírito Santo',
        33 => 'Rio de Janeiro',
        35 => 'São Paulo',
        // Sul
        41 => 'Paraná',
        42 => 'Santa Catarina',
        43 => 'Rio Grande do Sul',
        // Centro Oeste
        50 => 'Mato Grosso do Sul',
        51 => 'Mato Grosso',
        52 => 'Goiás',
        53 => 'Distrito Federal',
    ];

    private static array $typeEmissions = [
        1 => 'Emissão Normal',
        2 => 'Contigência em Formulário de Segurança',
        3 => 'Contigência SCAN',
        4 => 'Contigência EPEC',
        5 => 'Contigência em Formulário de Segurança FS-DA',
        6 => 'Contigência SVC-AN',
        7 => 'Contigência SVC-RS',
    ];

    private static array $months = [
        '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',
    ];

    private static $message = '';

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function federativeUnitCode(): int
    {
        return $this->value['cUF'];
    }

    public function monthEmission(): string
    {
        return substr($this->value['YYMM'], 2, 2);
    }

    public function model(): int
    {
        return $this->value['model'];
    }

    public function series(): string
    {
        return $this->value['series'];
    }

    public function emitter(): string
    {
        return $this->value['emitter'];
    }

    public function typeEmission(): int
    {
        return $this->value['typeEmission'];
    }

    public function numbers(): string
    {
        return implode('', $this->value);
    }

    public function format(): string
    {
        return implode('-', $this->value);
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public static function decode(string $value): array
    {
        $value = preg_replace('/[^0-9]/', '', $value);

        $key['cUF'] = substr($value, self::$characterPosition['cUF'][0], self::$characterPosition['cUF'][1]);
        $key['YYMM'] = substr($value, self::$characterPosition['YYMM'][0], self::$characterPosition['YYMM'][1]);
        $key['emitter'] = substr($value, self::$characterPosition['emitter'][0], self::$characterPosition['emitter'][1]);
        $key['model'] = substr($value, self::$characterPosition['model'][0], self::$characterPosition['model'][1]);
        $key['series'] = substr($value, self::$characterPosition['series'][0], self::$characterPosition['series'][1]);
        $key['numbers'] = substr($value, self::$characterPosition['numbers'][0], self::$characterPosition['numbers'][1]);
        $key['typeEmission'] = substr($value, self::$characterPosition['typeEmission'][0], self::$characterPosition['typeEmission'][1]);
        $key['codeNumeric'] = substr($value, self::$characterPosition['codeNumeric'][0], self::$characterPosition['codeNumeric'][1]);
        $key['dv'] = substr($value, self::$characterPosition['dv'][0], self::$characterPosition['dv'][1]);

        return $key;
    }

    public static function random(): self
    {
        $key['cUF'] = array_keys(self::$federativeUnitCodes)[random_int(0, 26)];
        $key['YYMM'] = date('y').self::$months[random_int(0, 11)];
        $key['emitter'] = Cnpj::random()->numbers();
        $key['model'] = 55;
        $key['series'] = random_int(100, 999);
        $key['numbers'] = random_int(111111111, 333333333);
        $key['typeEmission'] = random_int(1, 7);
        $key['codeNumeric'] = random_int(11111111, 33333333);
        $key['dv'] = 1;

        return self::create(implode('', $key));
    }

    protected static function validYearMonth(array $key): bool
    {
        $year = (int) substr($key['YYMM'], 0, 2);

        if ($year <= 0) {
            return false;
        }

        $month = substr($key['YYMM'], 2, 2);

        if (! in_array($month, self::$months, true)) {
            return false;
        }

        return true;
    }

    protected static function validEmitter(array $key): bool
    {
        if (Cnpj::isValid($key['emitter'])) {
            return true;
        }
        if (Cpf::isValid(substr($key['emitter'], 3, 11))) {
            return true;
        }

        return false;
    }

    public static function isValid(string $value): bool
    {
        if (strlen($value) !== self::$characterLimit) {
            self::$message = 'Should contain 44 characters';

            return false;
        }

        $key = self::decode($value);

        if (! array_key_exists($key['cUF'], self::$federativeUnitCodes)) {
            self::$message = 'cUF invalid';

            return false;
        }

        if (! self::validYearMonth($key)) {
            self::$message = 'Year or Month invalid';

            return false;
        }

        if (! self::validEmitter($key)) {
            self::$message = 'Emitter invalid';

            return false;
        }

        if (! array_key_exists($key['typeEmission'], self::$typeEmissions)) {
            self::$message = 'Type emission invalid';

            return false;
        }

        if ($key['series'] < 1 or $key['series'] > 999) {
            self::$message = 'Series invalid';

            return false;
        }

        return true;
    }

    public function equals(self $other): bool
    {
        return $this->numbers() === $other->numbers();
    }

    public function __toString(): string
    {
        return $this->numbers();
    }

    public static function create(string $value): self
    {
        if (! self::isValid($value)) {
            throw new InvalidArgumentException('Invalid NFe Key! '.self::$message);
        }

        $key = self::decode($value);

        return new self($key);
    }
}
