# Latte

This package is a PHP library that can be installed via composer. 
It provides a set of value objects that can be used in various 
applications. The aim of this package is to simplify the process of 
with value objects and to ensure that they are used consistently throughout the codebase.

## Install

To install this package in your project, use the following composer command:

```bash
composer require marcelofabianov/latte
```
### Features

Current version: v1.4.9

**ValueObject**

- [x] Uuid
- [x] Cnpj
- [x] Cpf
- [x] DocumentRegistration
- [x] ApplyMask
- [x] IpAddress
- [x] Email
- [x] Json
- [x] ExternalCode
- [x] Hostname
- [x] FederativeUnit
- [x] NFeKey
- [x] Monetary
- [x] CTeKey
- [ ] ZipCode
- [ ] Phone
- [ ] ExpiresIn

**Laravel Cast**

- [x] NFeKeyCast
- [x] CTeKeyCast
- [x] ExternalCodeCast
- [x] JsonCast
- [x] RegistrationDocumentCast
- [x] UuidCast
- [x] EmailCast
- [x] MonetaryCast

**Helpers**

- [x] StrSanitizer (Helper)
- [x] NumericDecimalSanitizer (Helper)
- [x] Debug (Helper)