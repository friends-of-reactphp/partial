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

    public function testBindWithPlaceholder()
    {
        $add = $this->createAddFunction();
        $addFun = Curry::bind($add, Curry::…(), 10);
        $this->assertSame(20, $addFun(10));
        $this->assertSame(30, $addFun(20));
    }

    public function testBindWithMultiplePlaceholders()
    {
        $prod = $this->createProdFunction();
        $prodTwo = Curry::bind($prod, Curry::…(), 2, Curry::…());
        $this->assertSame(4, $prodTwo(1, 2));
        $this->assertSame(6, $prodTwo(1, 3));
        $this->assertSame(8, $prodTwo(2, 2));
        $this->assertSame(24, $prodTwo(3, 4));
        $this->assertSame(48, $prodTwo(3, 8));
    }

    public function testStringConversion()
    {
        $add = $this->createAddFunction();
        $addTwo = Curry::bind($add, Curry::…(), 2);

        $this->setExpectedException(
            'InvalidArgumentException',
            'Cannot resolve parameter placeholder at position 0. Parameter stack is empty'
        );
        $addTwo();
    }

    private function createAddFunction()
    {
        return function ($a, $b) {
            return $a + $b;
        };
    }

    private function createProdFunction()
    {
        return function ($a, $b, $c) {
            return $a * $b * $c;
        };
    }
}
