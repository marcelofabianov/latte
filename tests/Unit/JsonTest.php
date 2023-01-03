<?php

declare(strict_types=1);

use Latte\Json;

it('should generate an instance that represents a JSON when constructed with a string')
    ->expect(Json::create('{"name":"valid"}'))
    ->toBeInstanceOf(Json::class);

it('should return an object when creating a JSON instance from a string')
    ->expect(Json::create('{"name":"valid"}')->decode())
    ->toBeObject();

it('should return a JSON string when provided with an array')
    ->expect(Json::create(['name' => 'valid'])->encode())
    ->toBeString();

it('should return a string when requested')
    ->expect((string) Json::create(['name' => 'valid']))
    ->toBeString();

it('should return true when the instances are equal')
    ->expect(Json::create(['name' => 'valid'])->equals(Json::create(['name' => 'valid'])))
    ->toBeTrue();
