<?php

declare(strict_types=1);

function debug(...$vars): void
{
    echo '<pre>';
    foreach ($vars as $var) {
        var_dump($var);
        echo str_repeat('-', 80).PHP_EOL;
    }
    echo '</pre>';
    exit(1);
}
