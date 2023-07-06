<?php

declare(strict_types=1);

use Latte\RegistrationDocument;

it('Should return true when the CNPJ document belongs to a matrix')
    ->expect(RegistrationDocument::create('63003436000154')->isMatrix())->toBeTrue();

it('Should return false when the CNPJ document does not belong to a matrix')
    ->expect(RegistrationDocument::create('63003436000235')->isMatrix())->toBeFalse();

it('Should return false when the CPF document does not belong to a matrix')
    ->expect(RegistrationDocument::create('33784030041')->isMatrix())->toBeFalse();
