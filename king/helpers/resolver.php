<?php

function resolve()
{
    $seeds = [
        '/../config/config.php',
        '/../helpers/mail.php',
    ];
    $main = array_shift($seeds);
    foreach ($seeds as $seed) {
        require_once __DIR__.($seed);
    }

    return require __DIR__.($main);
}