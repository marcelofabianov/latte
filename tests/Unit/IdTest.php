<?php

declare(strict_types=1);

use Latte\Id;

it('should return true when the UUID is valid')
    ->expect(Id::isValid('f47ac10b-58cc-4372-a567-0e02b2c3d479'))
    ->toBeTrue();

it('should return false when the UUID is not valid')
    ->expect(Id::isValid('invalid'))
    ->toBeFalse();

it('should return true when the values are equal')
    ->expect(
        Id::create('f484404f-27df-4e63-a2d8-ad79be5b946c')
        ->equals(Id::create('f484404f-27df-4e63-a2d8-ad79be5b946c'))
    )->toBeTrue();

it('should return the value as a string')
    ->expect(Id::create('c2427e6a-682c-42ac-b399-940c33119b84'))
    ->toEqual('c2427e6a-682c-42ac-b399-940c33119b84');

it('should return a randomly generated valid UUID instance')
    ->expect(Id::random())
    ->toBeInstanceOf(Id::class)
    ->and(Id::isValid(Id::random()->getValue()))
    ->toBeTrue();

it('should throw an exception when an instance is created with an invalid UUID', function () {
    Id::create('invalid');
})->expectException(InvalidArgumentException::class);

it('should return a new instance when the UUID is valid')
    ->expect(Id::create('0665aaa5-c0ba-4855-a89d-fd1a098c36ba'))
    ->toBeInstanceOf(Id::class)
    ->and(Id::isValid('0665aaa5-c0ba-4855-a89d-fd1a098c36ba'))
    ->toBeTrue();
