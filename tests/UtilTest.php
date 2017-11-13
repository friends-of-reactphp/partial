<?php

namespace React\Partial;

use React\Partial\Util as Partial;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testBind()
    {
        $div = $this->createDivFunction();
        $divFun = Partial::bind($div, 10, 5);
        $this->assertSame(0.02, $divFun(100));
    }

    public function testBindRight()
    {
        $div = $this->createDivFunction();
        $divFun = Partial::bindRight($div, 10, 5);
        $this->assertSame(2, $divFun(100));
    }

    private function createDivFunction()
    {
        return function ($a, $b, $c) {
            return $a / $b / $c;
        };
    }
}
