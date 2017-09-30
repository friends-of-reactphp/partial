<?php

require __DIR__.'/../vendor/autoload.php';

use function React\Partial\bind;

$add = function ($a, $b) {
    return $a + $b;
};

$addOne = bind($add, 1);

echo sprintf("%s\n", $addOne(5));
// outputs 6
