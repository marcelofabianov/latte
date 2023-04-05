<?php

declare(strict_types=1);

use Latte\Money;

it('Should return an instance of Money')
    ->expect(Money::create(10.34))
    ->toBeInstanceOf(Money::class);

it('Should return the value of Money')
    ->expect(Money::create(10.00)->getValue())
    ->toBe(10.00);

it('Should return the currency of Money')
    ->expect(Money::create(10.00)->getCurrency())
    ->toBe('BRL');

it('Should return an instance of Money in string format')
    ->expect((string) Money::create(10.00))
    ->toBe('10 BRL');

it('Should return an instance of Money in array format')
    ->expect(Money::create(10.00)->jsonSerialize())
    ->toBe([
        'value' => 10.00,
        'currency' => 'BRL',
    ]);

it('Should compare two instances of Money')
    ->expect(
        Money::create(10.00)
            ->toEquals(Money::create(10.00))
    )
    ->toBeTrue();

it('Should receive string "10" without decimal places and return float 10.00')
    ->expect(Money::create('10')->getValue())
    ->toBe(10.00);

it('Should receive string "10.0" with one decimal place and return float 10.00')
    ->expect(Money::create('10.0')->getValue())
    ->toBe(10.00);

it('Should receive float "10.0" with one decimal place and return float 10.00')
    ->expect(Money::create(10.0)->getValue())
    ->toBe(10.00);

it('Should receive integer "10" and return float 10.00')
    ->expect(Money::create(10)->getValue())
    ->toBe(10.00);

it('Should receive float "00.40" and return float 0.40')
    ->expect(Money::create(00.40)->getValue())
    ->toBe(0.40);

it('Should receive string "00.40" and return float 0.40')
    ->expect(Money::create('00.40')->getValue())
    ->toBe(0.40);

it('Should receive string "00.400" and return float 0.40')
    ->expect(Money::create(00.400)->getValue())
    ->toBe(0.40);

it('Should receive string ".00" and return float 0.0')
    ->expect(Money::create('.00')->getValue())
    ->toBe(0.0);

it('Should receive integer "0" and return float 0.0')
    ->expect(Money::create(0)->getValue())
    ->toBe(0.0);

it('Should receive string "0" and return float 0.0')
    ->expect(Money::create('0')->getValue())
    ->toBe(0.0);
