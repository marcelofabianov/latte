<?php

declare(strict_types=1);

use Latte\Hostname;

it('should create an instance with the hostname as the name')
    ->expect(Hostname::create())
    ->toBeInstanceOf(Hostname::class);

it('should return true when the instances are equal')
    ->expect((Hostname::create())->equals(Hostname::create()))
    ->toBeTrue();

it('should return a string when requested')
    ->expect((Hostname::create())->getValue())
    ->toBeString()
    ->and((string) Hostname::create())
    ->toBeString();
