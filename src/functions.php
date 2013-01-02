<?php

namespace React\Curry;

function bind(/*$fn, $args...*/)
{
    $args = func_get_args();
    $fn = array_shift($args);

    return function () use ($fn, $args) {
        return call_user_func_array($fn, array_merge($args, func_get_args()));
    };
}
