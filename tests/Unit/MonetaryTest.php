<?php

declare(strict_types=1);

use Latte\Monetary;

it('Should return an instance of Monetary')
    ->expect(Monetary::create(10.34))
    ->toBeInstanceOf(Monetary::class);

it('Should return the value of Monetary')
    ->expect(Monetary::create(10.00)->getValue())
    ->toBeFloat()
    ->toBe(10.00);

it('Should return the currency of Monetary')
    ->expect(Monetary::create(10.00)->getCurrency())
    ->toBeString()
    ->toBe('BRL');

it('Should return an instance of Monetary in string format')
    ->expect((string) Monetary::create(10.00))
    ->toBeString()
    ->toBe('10 BRL');

it('Should return an instance of Monetary in array format')
    ->expect(Monetary::create(10.00)->jsonSerialize())
    ->toBeArray()
    ->toBe([
        'value' => 10.00,
        'currency' => 'BRL',
    ]);

it('Should compare two instances of Monetary')
    ->expect(
        Monetary::create(10.00)
            ->toEquals(Monetary::create(10.00))
    )
    ->toBeTrue();

it('Should receive string "10" without decimal places and return float 10.00')
    ->expect(Monetary::create('10')->getValue())
    ->toBeFloat()
    ->toBe(10.00);

it('Should receive string "10.0" with one decimal place and return float 10.00')
    ->expect(Monetary::create('10.0')->getValue())
    ->toBeFloat()
    ->toBe(10.00);

it('Should receive float "10.0" with one decimal place and return float 10.00')
    ->expect(Monetary::create(10.0)->getValue())
    ->toBeFloat()
    ->toBe(10.00);

it('Should receive integer "10" and return float 10.00')
    ->expect(Monetary::create(10)->getValue())
    ->toBeFloat()
    ->toBe(10.00);

it('Should receive float "00.40" and return float 0.40')
    ->expect(Monetary::create(00.40)->getValue())
    ->toBeFloat()
    ->toBe(0.40);

it('Should receive string "00.40" and return float 0.40')
    ->expect(Monetary::create('00.40')->getValue())
    ->toBe(0.40);

it('Should receive string "00.400" and return float 0.40')
    ->expect(Monetary::create(00.400)->getValue())
    ->toBeFloat()
    ->toBe(0.40);

it('Should receive string ".00" and return float 0.0')
    ->expect(Monetary::create('.00')->getValue())
    ->toBeFloat()
    ->toBe(0.0);

it('Should receive integer "0" and return float 0.0')
    ->expect(Monetary::create(0)->getValue())
    ->toBeFloat()
    ->toBe(0.0);

it('Should receive string "0" and return float 0.0')
    ->expect(Monetary::create('0')->getValue())
    ->toBeFloat()
    ->toBe(0.0);

it('Should receive a monetary value with a comma and return a float')
    ->expect(Monetary::create('10,34')->getValue())
    ->toBeFloat()
    ->toBe(10.34);

it('Should correctly convert a monetary value with comma decimal separator to a float')
    ->expect(Monetary::create('1000,34')->getValue())
    ->toBeFloat()
    ->toBe(1000.34);

it('Should receive a monetary value with comma as decimal separator and period as thousand separator and return a float')
    ->expect(Monetary::create('1.000,34')->getValue())
    ->toBeFloat()
    ->toBe(1000.34);

it('Should correctly convert a monetary value with comma decimal separator and period thousand separator to a float')
    ->expect(Monetary::create('1.000.000,34')->getValue())
    ->toBeFloat()
    ->toBe(1000000.34);

it('Should receive monetary instance with random float value')
    ->expect(Monetary::random())
    ->toBeInstanceOf(Monetary::class)
    ->and(Monetary::random()->getValue())
    ->toBeFloat();

it('Should return a string with 2 decimal places when given a float or integer')
    ->expect(Monetary::create(10)->getDecimal())
    ->toBeString()
    ->toBe('10.00')
    ->and(Monetary::create(10.0)->getDecimal())
    ->toBeString()
    ->toBe('10.00')
    ->and(Monetary::create(10.4)->getDecimal())
    ->toBeString()
    ->toBe('10.40');

it('Should return a formatted string for monetary value according to the BRL currency standard')
    ->expect(Monetary::create(10)->getFormat())
    ->toBeString()
    ->toBe('10,00')
    ->and(Monetary::create(10.4)->getFormat())
    ->toBeString()
    ->toBe('10,40');

it('Should return a valid json string with value rounded to 2 decimal places and currency when forcing a json_encode')
    ->expect(json_encode(Monetary::create(10.54), JSON_THROW_ON_ERROR))
    ->toBe('{"value":10.54,"currency":"BRL"}');

it('Should create a Monetary instance from an object with properties value and currency')
    ->expect(Monetary::create((object) ['value' => 10.54, 'currency' => 'USD']))
    ->toBeInstanceOf(Monetary::class)
    ->and(Monetary::create((object) ['value' => 10.54, 'currency' => 'USD'])->getValue())
    ->toBeFloat()
    ->toBe(10.54)
    ->and(Monetary::create((object) ['value' => 10.54, 'currency' => 'USD'])->getCurrency())
    ->toBe('USD');
