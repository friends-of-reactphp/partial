<?php

namespace React\Partial;

use React\Partial\Util as Partial;

class UtilTest extends \PHPUnit_Framework_TestCase
{
    public function testBindWithTwoArgs()
    {
        $add = $this->createAddFunction();
        $addOneAndFive = Partial::bind($add, 1, 5);
        $this->assertSame(6, $addOneAndFive());
    }

    private function createAddFunction()
    {
        return function ($a, $b) {
            return $a + $b;
        };
    }
}
