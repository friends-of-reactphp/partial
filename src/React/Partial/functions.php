<?php

namespace React\Partial;

use React\Partial\Placeholder;

function bind(/*$fn, $args...*/)
{
    $args = func_get_args();
    $fn = array_shift($args);

    return function () use ($fn, $args) {
        return call_user_func_array($fn, mergeParameters($args, func_get_args()));
    };
}

/**
 * @return Partial
 */
function …()
{
    return Placeholder::create();
}

/**
 * @return Partial
 */
function placeholder()
{
    return …();
}

/** @internal */
function mergeParameters(array $left, array $right)
{
    foreach ($left as $position => &$param) {
        if ($param instanceof Placeholder) {
            $param = $param->resolve($right, $position);
        }
    }

    return array_merge($left, $right);
}
