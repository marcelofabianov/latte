<?php

declare(strict_types=1);

use Latte\Email;

it('should return true when the email is valid')
    ->expect(Email::isValid('user@email.com'))
    ->toBeTrue();

it('should return false when the email is invalid')
    ->expect(Email::isValid('invalid'))
    ->toBeFalse();

it('should create an instance when the email is valid')
    ->expect(Email::create('user@email.com'))
    ->toBeInstanceOf(Email::class)
    ->and(Email::isValid('user@email.com'))
    ->toBeTrue();

it('should keep the email in lower case')
    ->expect(Email::create('USER@EMAIL.COM')->getValue())
    ->toBe('user@email.com')
    ->and(Email::create('USER@email.com')->getValue())
    ->toBe('user@email.com');
