<?php

declare(strict_types=1);

namespace Latte;

final class ExternalIpAddress
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

    public function equals(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    private static function capture(): string
    {
        $ipAddress = 'UNKNOWN';

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }

        return $ipAddress;
    }

    public static function random(): self
    {
        // Generate a random number between 0 and 255
        $ip1 = random_int(0, 255);
        $ip2 = random_int(0, 255);
        $ip3 = random_int(0, 255);
        $ip4 = random_int(0, 255);

        // Check if the IP is not in the private address range
        while (filter_var("$ip1.$ip2.$ip3.$ip4", FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) === false) {
            $ip1 = random_int(0, 255);
            $ip2 = random_int(0, 255);
            $ip3 = random_int(0, 255);
            $ip4 = random_int(0, 255);
        }

        return self::create("$ip1.$ip2.$ip3.$ip4");
    }

    public static function isValid(string $ipAddress): bool
    {
        if (str_starts_with($ipAddress, '192.168.') === true) {
            return false;
        }

        if ((bool) filter_var($ipAddress, FILTER_VALIDATE_IP) === false) {
            return false;
        }

        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) === false) {
            return false;
        }

        return true;
    }

    public static function create(mixed $value = null): self
    {
        if (! is_string($value) and ! is_null($value)) {
            throw new \RuntimeException('The provided argument must be of type string');
        }

        if (! is_null($value) and ! self::isValid($value)) {
            throw new \InvalidArgumentException(
                "IP: {$value}. A valid IP address that is not within a local network range must be provided"
            );
        }

        if (! is_null($value) and self::isValid($value)) {
            return new self($value);
        }

        return new self(self::capture());
    }
}
