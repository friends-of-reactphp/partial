<?php

namespace React\Partial;

use InvalidArgumentException;

final class Placeholder
{
    /**
     * @var null|static
     */
    private static $instance = null;

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function create()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param array $parameters
     * @param int   $position
     *
     * @return mixed
     */
    public function resolve(array &$parameters, $position)
    {
        if (count($parameters) === 0) {
            throw new InvalidArgumentException(
                sprintf('Cannot resolve parameter placeholder at position %d. Parameter stack is empty.', $position)
            );
        }

        return array_shift($parameters);
    }
}
