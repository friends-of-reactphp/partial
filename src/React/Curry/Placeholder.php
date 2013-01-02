<?php

namespace React\Curry;

final class Placeholder
{
    private static $instance;

    private function __construct()
    {
    }

    public function create()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function resolve(array &$args, $position)
    {
        if (count($args) === 0) {
            throw new \InvalidArgumentException(
                sprintf('Cannot resolve parameter placeholder at position %d. Parameter stack is empty', $position)
            );
        }

        return array_shift($args);
    }
}
