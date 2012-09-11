<?php

namespace React\Curry;

use React\Curry\Util as Curry;

class UtilTest extends \PHPUnit_Framework_TestCase
{
    public function testBindWithNoArgs()
    {
        $add = $this->createAddFunction();
        $newAdd = Curry::bind($add);
        $this->assertSame(6, $newAdd(1, 5));
    }

    public function testBindWithOneArg()
    {
        $add = $this->createAddFunction();
        $addOne = Curry::bind($add, 1);
        $this->assertSame(6, $addOne(5));
    }

    public function testBindWithTwoArgs()
    {
        $add = $this->createAddFunction();
        $addOneAndFive = Curry::bind($add, 1, 5);
        $this->assertSame(6, $addOneAndFive());
    }

    private function createAddFunction()
    {
        return function ($a, $b) {
            return $a + $b;
        };
    }
}
