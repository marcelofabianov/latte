<?php

declare(strict_types=1);

use Latte\CTeKey;

it('should return instance valid key')
    ->group('CTeKey')
    ->expect(CTeKey::create('41181033070814000828570070006123931077785491'))
    ->toBeInstanceOf(CTeKey::class)
    ->and(CTeKey::isValid('41181033070814000828570070006123931077785491'))
    ->toBeTrue();

it('should return true when both instances of CTeKey are equal')
    ->group('CTeKey')
    ->expect(
        CTeKey::create('41181033070814000828570070006123931077785491')
        ->equals(CTeKey::create('41181033070814000828570070006123931077785491'))
    )->toBeTrue();

it('should return a string when prompted for display')
    ->group('CTeKey')
    ->expect((string) CTeKey::create('41181033070814000828570070006123931077785491'))
    ->toBe('41181033070814000828570070006123931077785491');

it('should generate a valid random key')
    ->group('CTeKey')
    ->expect(CTeKey::isValid(CTeKey::random()->numbers()))
    ->toBeTrue();
