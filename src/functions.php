<?php

namespace React\Partial;

use Closure;

/**
 * @param string|callable $function
 *
 * @return Closure
 */
function bind($function)
{
    $carry = array_slice(func_get_args(), 1);

    return function () use ($function, $carry) {
        return call_user_func_array($function, mergeLeft($carry, func_get_args()));
    };
}

/**
 * @param string|callable $function
 *
 * @return Closure
 */
function bind_right($function)
{
    $carry = array_slice(func_get_args(), 1);

    return function () use ($function, $carry) {
        return call_user_func_array($function, mergeRight($carry, func_get_args()));
    };
}

/**
 * @return Placeholder
 */
function …()
{
    return Placeholder::create();
}

/**
 * @return Placeholder
 */
function placeholder()
{
    return …();
}

/**
 * Merges $right values into $left.
 *
 * @internal
 *
 * @param array $left
 * @param array $right
 *
 * @return array
 */
function mergeLeft(array $left, array $right)
{
    resolvePlaceholder($left, $right);

    return array_merge($left, $right);
}

/**
 * Merges $left values into $right.
 *
 * @internal
 *
 * @param array $left
 * @param array $right
 *
 * @return array
 */
function mergeRight(array $left, array $right)
{
    resolvePlaceholder($left, $right);

    return array_merge($right, $left);
}

/**
 * Resolves and shifts a placeholder value from $source to $parameters.
 *
 * @internal
 *
 * @param array $parameters
 * @param array $source
 */
function resolvePlaceholder(array &$parameters, array &$source)
{
    foreach ($parameters as $position => &$param) {
        if ($param instanceof Placeholder) {
            $param = $param->resolve($source, $position);
        }
    }
}
