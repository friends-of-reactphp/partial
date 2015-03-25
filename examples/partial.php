<?php

require __DIR__ . '/../vendor/autoload.php';

use React\Partial;

$add = function ($a, $b) {
    return $a + $b;
};

$addOne = Partial\bind($add, 1);

print $addOne(5) . "\n"; // 1 + 5 = 6
