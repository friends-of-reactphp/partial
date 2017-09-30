<?php

namespace React\Partial;

/**
 * @return callable
 */
function bind(callable $fn, ...$bound)
{
    return function (...$args) use ($fn, $bound) {
        return $fn(...mergeLeft($bound, $args));
    };
}

/**
 * @return callable
 */
function bind_right(callable $fn, ...$bound)
{
    return function (...$args) use ($fn, $bound) {
        return $fn(...mergeRight($bound, $args));
    };
}

/**
 * @return Placeholder
 **/
function …()
{
    return Placeholder::create();
}

/**
 * @return Placeholder
 **/
function placeholder()
{
    return …();
}

/** @internal */
function mergeLeft(array $left, array $right)
{
    resolvePlaceholder($left, $right);
    return array_merge($left, $right);
}

/** @internal */
function mergeRight(array $left, array $right)
{
    resolvePlaceholder($left, $right);
    return array_merge($right, $left);
}

/** @internal */
function resolvePlaceholder(array &$parameters, array &$source)
{
    foreach ($parameters as $position => &$param) {
        if ($param instanceof Placeholder) {
            $param = $param->resolve($source, $position);
        }
    }
}
