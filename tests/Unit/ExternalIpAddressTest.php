<?php

declare(strict_types=1);

use Latte\ExternalIpAddress;

it('should return true when the provided IP is valid')
    ->expect(ExternalIpAddress::isValid('129.133.250.35'))
    ->toBeTrue();

it('should return false when an invalid IP is provided')
    ->expect(ExternalIpAddress::isValid('invalid'))
    ->toBeFalse();

it('should return false when a local network range IP is provided')
    ->expect(ExternalIpAddress::isValid('192.168.0.1'))
    ->toBeFalse();

it('should generate a randomly valid IP address')
    ->expect(ExternalIpAddress::random())
    ->toBeInstanceOf(ExternalIpAddress::class)
    ->and(ExternalIpAddress::isValid(ExternalIpAddress::random()->getValue()))
    ->toBeTrue();

it('should not create the instance when the IP is invalid', function () {
    ExternalIpAddress::create('invalid');
})->expectException(InvalidArgumentException::class);

it('should return an instance when given a valid IP')
    ->expect(ExternalIpAddress::create('103.3.222.2'))
    ->toBeInstanceOf(ExternalIpAddress::class);

it(
    "should return the captured IP when no IP is provided, or return 'unknown IP' if it is not possible to capture",
    function () {
        $ipAddress = (ExternalIpAddress::create())->getValue();
        expect(ExternalIpAddress::isValid($ipAddress) === true or $ipAddress === 'UNKNOWN')
            ->toBeTrue();
    });

it('should return a string when requested')
    ->expect((string) ExternalIpAddress::create('191.54.72.96'))
    ->toEqual('191.54.72.96')
    ->and(ExternalIpAddress::create('191.54.72.96')->getValue())
    ->toEqual('191.54.72.96');
