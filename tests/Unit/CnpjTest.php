<?php

declare(strict_types=1);

use Latte\Cnpj;

it('should validate the CNPJ format as true', function () {
    expect(Cnpj::isValid('22.928.992/0001-54'))
        ->toBeTrue();
});

it('should validate the CNPJ format as false', function () {
    expect(Cnpj::isValid('00.000.000/0000/00'))
        ->toBeFalse()
        ->and(Cnpj::isValid('00000000000000'))
        ->toBeFalse();
});

it('should return only numbers', function () {
    $cnpj = Cnpj::create('25.515.252/0001-84');
    expect($cnpj->numbers())->toEqual('25515252000184');
});

it('should return formatted CNPJ', function () {
    $cnpj = Cnpj::create('21452390000100');
    expect('21.452.390/0001-00')->toEqual($cnpj->format());
});

it('should return false when the CNPJ is not valid', function () {
    expect(Cnpj::isValid('11.444.777/0001-62'))
        ->toBeFalse();
});

it('should return true when the CNPJ is valid', function () {
    expect(Cnpj::isValid('11.444.777/0001-61'))
        ->toBeTrue();
});

it('should return false when CNPJ has more than 14 digits', function () {
    expect(Cnpj::isValid('11.444.777/0001-543'))
        ->toBeFalse();
});

it('should return false when the number of digits in the CNPJ is less than 14.', function () {
    expect(Cnpj::isValid('11.444.777/001-54'))
        ->toBeFalse();
});

it('should return false when CNPJ starts with 00', function () {
    expect(Cnpj::isValid('00.000.000/0000-00'))
        ->toBeFalse();
});

it('should generate a valid CNPJ', function () {
    $cnpj = Cnpj::random();

    expect(Cnpj::isValid($cnpj->format()))
        ->toBeTrue();
});
