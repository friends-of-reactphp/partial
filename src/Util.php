<?php

namespace React\Partial;

final class Util
{
    /**
     * @param string|callable $function
     *
     * @return mixed
     */
    public static function bind($function)
    {
        return call_user_func_array('React\Partial\bind', func_get_args());
    }

    /**
     * @param string|callable $function
     *
     * @return mixed
     */
    public static function bindRight($function)
    {
        return call_user_func_array('React\Partial\bind_right', func_get_args());
    }
}
