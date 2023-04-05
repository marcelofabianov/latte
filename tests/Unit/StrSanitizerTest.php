<?php

declare(strict_types=1);

use Latte\Helpers\StrSanitizer;

it('Should receive a string with accents and return a string without accents')
    ->expect(StrSanitizer::alphanumeric('áàãâéêíóôõúçÁÀÃÂÉÊÍÓÔÕÚÇ'))
    ->toBe('aaaaeeioooucAAAAEEIOOOUC');

it('Should receive a string with spaces and return a string without spaces')
    ->expect(StrSanitizer::alphanumeric(' a '))
    ->toBe('a');

it('Should receive a string with special characters and return a string without special characters')
    ->expect(StrSanitizer::alphanumeric('!@#$%¨&a*()_+'))
    ->toBe('a');

it('Should receive a string with Unicode characters and return only the allowed ones')
    ->expect(StrSanitizer::alphanumeric('漢字、かな、カナ'))
    ->toBe('');

it('Should receive an empty string and return an empty string')
    ->expect(StrSanitizer::alphanumeric(''))
    ->toBe('');

it('Should receive a string with accented letters, special characters, and spaces and return a sanitized string without accents, special characters, and spaces')
    ->expect(StrSanitizer::alphanumeric('  áéíÓ!@#a   '))
    ->toBe('aeiOa');

it('Should receive a string with only numbers and return the string unchanged')
    ->expect(StrSanitizer::alphanumeric('1234567890'))
    ->toBe('1234567890');

it('Should receive a string with only uppercase and lowercase letters and return the string unchanged')
    ->expect(StrSanitizer::alphanumeric('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'))
    ->toBe('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');

it('Should receive a string with only uppercase and lowercase letters and numbers and return the string unchanged')
    ->expect(StrSanitizer::alphanumeric('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890'))
    ->toBe('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890');
