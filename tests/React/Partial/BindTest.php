<?php

namespace React\Partial;

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

    public function testBindWithPlaceholder()
    {
        $add = $this->createAddFunction();
        $addFun = bind($add, …(), 10);
        $this->assertSame(20, $addFun(10));
        $this->assertSame(30, $addFun(20));
    }

    public function testBindWithMultiplePlaceholders()
    {
        $prod = $this->createProdFunction();
        $prodTwo = bind($prod, …(), 2, …());
        $this->assertSame(4, $prodTwo(1, 2));
        $this->assertSame(6, $prodTwo(1, 3));
        $this->assertSame(8, $prodTwo(2, 2));
        $this->assertSame(24, $prodTwo(3, 4));
        $this->assertSame(48, $prodTwo(3, 8));
    }

    public function testPlaceholderParameterPosition()
    {
        $substr = bind('substr', …(), 0, …());
        $this->assertSame('foo', $substr('foo', 3));
        $this->assertSame('fo', $substr('foo', 2));
        $this->assertSame('f', $substr('foo', 1));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Cannot resolve parameter placeholder at position 0. Parameter stack is empty
     */
    public function testStringConversion()
    {
        $add = $this->createAddFunction();
        $addTwo = bind($add, …(), 2);

        $addTwo();
    }

    public function testAliasForUnicodePlaceholderFunction()
    {
        $this->assertSame(…(), placeholder());
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
