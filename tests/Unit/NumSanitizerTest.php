<?php

declare(strict_types=1);

use Latte\Helpers\NumSanitizer;

it('should sanitize integer string to integer')
    ->expect(NumSanitizer::numericDecimal('12345'))
    ->toBeInt()
    ->toEqual(12345);

it('should sanitize float string to float')
    ->expect(NumSanitizer::numericDecimal('12345.67'))
    ->toBeFloat()
    ->toEqual(12345.67);

it('should sanitize string with leading/trailing spaces to integer')
    ->expect(NumSanitizer::numericDecimal(' 12345 '))
    ->toBeInt()
    ->toEqual(12345);

it('should sanitize string with leading/trailing spaces to float')
    ->expect(NumSanitizer::numericDecimal(' 12345.67 '))
    ->toBeFloat()
    ->toEqual(12345.67);

it('should sanitize string with non-numeric characters to integer')
    ->expect(NumSanitizer::numericDecimal('12a34b5'))
    ->toBeInt()
    ->toEqual(12345);

it('should sanitize empty string to integer')
    ->expect(NumSanitizer::numericDecimal(''))
    ->toBeInt()
    ->toEqual(0);

it('should sanitize string with only decimal separator to float')
    ->expect(NumSanitizer::numericDecimal('.'))
    ->toBeFloat()
    ->toEqual(0.0);

it('should sanitize string with mixed decimal separators to float')
    ->expect(NumSanitizer::numericDecimal('1.234,56'))
    ->toBeFloat()
    ->toEqual(1234.56);

it('should sanitize string with non-numeric characters to float')
    ->expect(NumSanitizer::numericDecimal('12.3a4,b5'))
    ->toBeFloat()
    ->toEqual(1234.5);

it('should sanitize string with commas to float')
    ->skip('pending')
    ->expect(NumSanitizer::numericDecimal('1,234.56'))
    ->toBeFloat()
    ->toEqual(1234.56);

it('should sanitize string with multiple decimal separators to float')
    ->skip('pending')
    ->expect(NumSanitizer::numericDecimal('12.34.56'))
    ->toBeFloat()
    ->toEqual(1234.56);

it('should sanitize string with negative sign to integer')
    ->skip('pending')
    ->expect(NumSanitizer::numericDecimal('-12345'))
    ->toBeInt()
    ->toEqual(-12345);

it('should sanitize string with negative sign to float')
    ->skip('pending')
    ->expect(NumSanitizer::numericDecimal('-12345.67'))
    ->toBeFloat()
    ->toEqual(-12345.67);
