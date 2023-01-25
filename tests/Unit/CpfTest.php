<?php

declare(strict_types=1);

use Latte\Cpf;

it('should validate the CPF format as true', function () {
    expect(Cpf::isValid('111.222.333-44'))
        ->toBeFalse();
});

it('should validate the CPF format as false', function () {
    expect(Cpf::isValid('00.000.000/0000/00'))
        ->toBeFalse()
        ->and(Cpf::isValid('00000000000000'))
        ->toBeFalse();
});

it('should return only numbers', function () {
    $cpf = Cpf::create('600.102.330-16');
    expect($cpf->numbers())->toEqual('60010233016');
});

it('should return formatted CPF', function () {
    $cpf = Cpf::create('03900520003');
    expect('039.005.200-03')->toEqual($cpf->format());
});

it('should return false when the CPF is not valid', function () {
    expect(Cpf::isValid('111.222.333-99'))
        ->toBeFalse();
});

it('should return true when the CPF is valid', function () {
    expect(Cpf::isValid('868.061.260-06'))
        ->toBeTrue();
});

it('should return false when CPF has more than 11 digits', function () {
    expect(Cpf::isValid('111.222.333-455'))
        ->toBeFalse();
});

it('should return false when the number of digits in the CPF is less than 11', function () {
    expect(Cpf::isValid('111.222.333-4'))
        ->toBeFalse();
});

it('should return false when the CPF starts with 3 consecutive zeros', function () {
    expect(Cpf::isValid('000.000.000-00'))
        ->toBeFalse();
});

it('should generate a valid CPF', function () {
    $cpf = Cpf::random();
    expect(Cpf::isValid($cpf->format()))->toBeTrue();
});
