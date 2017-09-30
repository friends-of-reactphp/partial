<?php

namespace React\Partial;

final class Util
{
    public static function bind(/*$fn, $args...*/)
    {
        return call_user_func_array('React\Partial\bind', func_get_args());
    }

    public static function bindRight(/*$fn, $args...*/)
    {
        return call_user_func_array('React\Partial\bind_right', func_get_args());
    }
}
