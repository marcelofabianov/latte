<?php

declare(strict_types=1);

use Latte\FederativeUnit;

it('should create the instance when the federative unit is true')
    ->expect(FederativeUnit::create('MG'))
    ->toBeInstanceOf(FederativeUnit::class);

it('should return an exception when trying to create an instance with an invalid federal unit', function () {
    FederativeUnit::create('Invalid');
})->expectException(InvalidArgumentException::class);

it('should return true when a valid federal unit is provided')
    ->expect(FederativeUnit::isValid('GO'))
    ->toBeTrue();

it('should return false when an invalid federal unit is provided')
    ->expect(FederativeUnit::isValid('invalida'))
    ->toBeFalse();

it('should return the full name of the federal unit')
    ->expect(FederativeUnit::create('GO')->display())
    ->toEqual('Goiás');

it('should return the abbreviation of a federal unit.')
    ->expect(FederativeUnit::create('MG')->initials())
    ->toEqual('MG');

it('should return random federal unit.')
    ->expect(FederativeUnit::random())
    ->toBeInstanceOf(FederativeUnit::class)
    ->and(FederativeUnit::isValid(FederativeUnit::random()->initials()))
    ->toBeTrue();
