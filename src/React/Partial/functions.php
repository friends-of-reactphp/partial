<?php

namespace React\Partial;

function bind(/*$fn, $args...*/)
{
    $args = func_get_args();
    $fn = array_shift($args);

    return function () use ($fn, $args) {
        return call_user_func_array($fn, mergeLeft($args, func_get_args()));
    };
}

function bind_right(/*$fn, $args...*/)
{
    $args = func_get_args();
    $fn = array_shift($args);

    return function () use ($fn, $args) {
        return call_user_func_array($fn, mergeRight($args, func_get_args()));
    };
}

/** @return Placeholder */
function …()
{
    return Placeholder::create();
}

/** @return Placeholder */
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
