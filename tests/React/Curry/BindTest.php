<?php

namespace React\Curry;

class BindTest extends \PHPUnit_Framework_TestCase
{
    public function testBindWithNoArgs()
    {
        $add = $this->createAddFunction();
        $newAdd = bind($add);
        $this->assertSame(6, $newAdd(1, 5));
    }

    public function testBindWithOneArg()
    {
        $add = $this->createAddFunction();
        $addOne = bind($add, 1);
        $this->assertSame(6, $addOne(5));
    }

    public function testBindWithTwoArgs()
    {
        $add = $this->createAddFunction();
        $addOneAndFive = bind($add, 1, 5);
        $this->assertSame(6, $addOneAndFive());
    }

    private function createAddFunction()
    {
        return function ($a, $b) {
            return $a + $b;
        };
    }
}
