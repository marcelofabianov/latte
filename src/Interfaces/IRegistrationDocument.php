<?php

declare(strict_types=1);

namespace Latte\Interfaces;

interface IRegistrationDocument
{
    public function numbers(): string;

    public function format(): string;

    public static function type(): string;

    public static function random(): self;

    public function equals(self $other): bool;

    public function __toString(): string;
}
