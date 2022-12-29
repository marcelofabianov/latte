<?php

declare(strict_types=1);

use Latte\Json;

it('The instance should only be created when the JSON is valid')
    ->expect(Json::create('{ name: "Bob"}'))
    ->toBeInstanceOf(Json::class);
