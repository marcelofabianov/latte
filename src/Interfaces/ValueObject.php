<?php

declare(strict_types=1);

namespace Latte\Interfaces;

interface ValueObject
{
    public function getValue(): mixed;

    public function equals(self $other): bool;

    public function __toString();

    public static function create($value): self;
}
