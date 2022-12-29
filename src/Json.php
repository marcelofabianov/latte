<?php

declare(strict_types=1);

namespace Latte;

use InvalidArgumentException;
use JsonException;
use Latte\Interfaces\ValueObject;
use stdClass;

final class Json implements ValueObject
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

    public function equals(ValueObject $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * @throws JsonException
     */
    public function decode(string $value): stdClass|array|false
    {
        return json_decode($value, false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public static function encode(array|stdClass $value): string|false
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public static function create($value): ValueObject
    {
        if (is_array($value) || is_object($value)) {
            $value = self::encode($value);
        }
        if (is_string($value)) {
            return new self($value);
        }

        throw new InvalidArgumentException('Invalid JSON');
    }
}
