<?php

declare(strict_types=1);

use Latte\NFeKey;

it('should return instance valid key')
    ->group('NFeKey')
    ->expect(NFeKey::create('51180662182092000559550010000230361312086413'))
    ->toBeInstanceOf(NFeKey::class)
    ->and(NFeKey::isValid('51180662182092000559550010000230361312086413'))
    ->toBeTrue();

it('should return true when both instances of NFeKey are equal')
    ->group('NFeKey')
    ->expect(
        NFeKey::create('51180662182092000559550010000230361312086413')
        ->equals(NFeKey::create('51180662182092000559550010000230361312086413'))
    )->toBeTrue();

it('should return a string when prompted for display')
    ->group('NFeKey')
    ->expect((string) NFeKey::create('51180662182092000559550010000230361312086413'))
    ->toBe('51180662182092000559550010000230361312086413');

it('should generate a valid random key')
    ->group('NFeKey')
    ->expect(NFeKey::isValid(NFeKey::random()->numbers()))
    ->toBeTrue();

it('should return false when model is invalid')
    ->group('NFeKey')
    ->expect(NFeKey::isValid('51180662182092000559560010000230361312086413'))
    ->toBeFalse();
