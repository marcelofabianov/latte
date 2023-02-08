<?php

declare(strict_types=1);

use Latte\NFeKey;

it('should return instance valid key')
    ->group('NFeKey')
    ->expect(NFeKey::create('51180662182092000559550010000230361312086413'))
    ->toBeInstanceOf(NFeKey::class)
    ->and(NFeKey::isValid('51180662182092000559550010000230361312086413'))
    ->toBeTrue();
