<?php

namespace React\Curry;

use React\Curry\Placeholder;

function bind(/*$fn, $args...*/)
{
    $args = func_get_args();
    $fn = array_shift($args);

    return function () use ($fn, $args) {
        return call_user_func_array($fn, Util::mergeParameters($args, func_get_args()));
    };
}

function …()
{
    return Placeholder::create();
}

function placeholder()
{
    return …();
}
