<?php

declare(strict_types=1);

use Latte\Uuid;

it('should return true when the UUID is valid')
    ->expect(Uuid::isValid('f47ac10b-58cc-4372-a567-0e02b2c3d479'))
    ->toBeTrue();

it('should return false when the UUID is not valid')
    ->expect(Uuid::isValid('invalid'))
    ->toBeFalse();

it('should return true when the values are equal')
    ->expect(
        Uuid::create('f484404f-27df-4e63-a2d8-ad79be5b946c')
        ->equals(Uuid::create('f484404f-27df-4e63-a2d8-ad79be5b946c'))
    )->toBeTrue();

it('should return the value as a string')
    ->expect(Uuid::create('c2427e6a-682c-42ac-b399-940c33119b84'))
    ->toEqual('c2427e6a-682c-42ac-b399-940c33119b84');

it('should return a randomly generated valid UUID instance')
    ->expect(Uuid::random())
    ->toBeInstanceOf(Uuid::class)
    ->and(Uuid::isValid(Uuid::random()->getValue()))
    ->toBeTrue();

it('should throw an exception when an instance is created with an invalid UUID', function () {
    Uuid::create('invalid');
})->expectException(InvalidArgumentException::class);

it('should return a new instance when the UUID is valid')
    ->expect(Uuid::create('0665aaa5-c0ba-4855-a89d-fd1a098c36ba'))
    ->toBeInstanceOf(Uuid::class)
    ->and(Uuid::isValid('0665aaa5-c0ba-4855-a89d-fd1a098c36ba'))
    ->toBeTrue();
