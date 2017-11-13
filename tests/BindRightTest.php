<?php

namespace React\Partial;

use PHPUnit\Framework\TestCase;

class BindRightTest extends TestCase
{
    public function testBindWithNoArgs()
    {
        $div = $this->createDivFunction();
        $newDiv = bind_right($div);
        $this->assertSame(2, $newDiv(4, 2));
    }

    public function testBindWithOneArg()
    {
        $div = $this->createDivFunction();
        $divOne = bind_right($div, 4);
        $this->assertSame(0.5, $divOne(2));
    }

    public function testBindWithTwoArgs()
    {
        $div = $this->createDivFunction();
        $divTwo = bind_right($div, 2, 4);
        $this->assertSame(0.5, $divTwo());
    }

    public function testBindWithPlaceholder()
    {
        $div = $this->createDivFunction();
        $divFun = bind_right($div, …(), 4);
        $this->assertSame(5, $divFun(20));
        $this->assertSame(10, $divFun(40));
    }

    public function testBindWithMultiplePlaceholders()
    {
        $div = $this->createDivFunction();
        $divTwo = bind_right($div, …(), 2, …());
        $this->assertSame(1, $divTwo(4, 2));
        $this->assertSame(1, $divTwo(10, 5));
        $this->assertSame(25, $divTwo(100, 2));
    }

    public function testPlaceholderParameterPosition()
    {
        $substr = bind_right('substr', …(), 0, …());
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
        $div = $this->createDivFunction();
        $divTwo = bind_right($div, …(), 2);

        $divTwo();
    }

    public function testAliasForUnicodePlaceholderFunction()
    {
        $this->assertSame(…(), placeholder());
    }

    private function createDivFunction()
    {
        return function () {
            $args = func_get_args();
            $value = array_shift($args);
            foreach ($args as $arg) {
                $value /= $arg;
            }
            return $value;
        };
    }
}
