<?php

require __DIR__.'/../vendor/autoload.php';

use React\Curry\Util as Curry;

$add = function ($a, $b) {
    return $a + $b;
};

$addOne = Curry::bind($add, 1);

echo sprintf("%s\n", $addOne(5));
// outputs 6
