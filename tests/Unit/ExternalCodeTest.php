<?php

declare(strict_types=1);

use Latte\ExternalCode;

it('should return false when the numeric value is not an integer')
    ->expect(ExternalCode::isValid(434.23))
    ->toBeFalse();

it('should return false when an invalid UUID string is provided')
    ->expect(ExternalCode::isValid('invalid'))
    ->toBeFalse();

it('should return true when a valid UUID is provided')
    ->expect(ExternalCode::isValid('ec5fe5b6-571b-493f-b229-e715da785803'))
    ->toBeTrue();

it('should return true when an integer is provided')
    ->expect(ExternalCode::isValid(432))
    ->toBeTrue();

it('should create an instance when the provided value is valid')
    ->expect(ExternalCode::create(435))
    ->toBeInstanceOf(ExternalCode::class);

it('should not create an instance when the provided value is invalid', function () {
    ExternalCode::create('invalid');
})->expectException(InvalidArgumentException::class);

it('should generate a randomly valid ExternalCode')
    ->expect(ExternalCode::random())
    ->toBeInstanceOf(ExternalCode::class)
    ->and(ExternalCode::isValid(ExternalCode::random()->getValue()))
    ->toBeTrue();

it('should generate a randomly number valid ExternalCode')
    ->expect(ExternalCode::random(true))
    ->toBeInstanceOf(ExternalCode::class)
    ->and(ExternalCode::isValid(ExternalCode::random(true)->getValue()))
    ->toBeTrue();

it('should return true when both ExternalCodes are equal')
    ->expect((ExternalCode::create(111))->equals(ExternalCode::create(111)))
    ->toBeTrue();

it('should return a string when the value is requested')
    ->expect(ExternalCode::create(222))
    ->toEqual('222')
    ->and(ExternalCode::create('9a2e0f3e-c5c5-486f-8a70-46ebbbbb7475'))
    ->toEqual('9a2e0f3e-c5c5-486f-8a70-46ebbbbb7475')
    ->and(ExternalCode::create(444)->getValue())
    ->toEqual('444');
