<?php

namespace React\Curry;

final class Util
{
    public static function …()
    {
        return Placeholder::create();
    }

    public static function placeholder()
    {
        return self::…();
    }

    public static function bind(/*$fn, $args...*/)
    {
        $args = func_get_args();
        $fn = array_shift($args);

        return function () use ($fn, $args) {
            return call_user_func_array($fn, Util::mergeParameters($args, func_get_args()));
        };
    }

    public static function mergeParameters(array $left, array $right)
    {
        foreach ($left as $position => &$param) {
            if ($param instanceof Placeholder) {
                $param = $param->resolve($right, $position);
            }
        }

        return array_merge($left, $right);
    }
}
