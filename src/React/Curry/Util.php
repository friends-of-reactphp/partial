<?php

namespace React\Curry;

class Util
{
    public static function bind(/*$fn, $args...*/)
    {
        $args = func_get_args();
        $fn = array_shift($args);

        return function () use ($fn, $args) {
            return call_user_func_array($fn, array_merge($args, func_get_args()));
        };
    }
}
