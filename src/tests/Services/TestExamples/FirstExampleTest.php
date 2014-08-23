<?php

class FirstExampleTest extends PHPUnit_Framework_TestCase
{

    public function test_true_is_true()
    {
        $foo = true;
        $this->assertTrue($foo);
    }

    public function test_false_is_false()
    {
        $bar = false;
        $this->assertFalse($bar);
    }

    public function test_false_is_not_true()
    {
        $baz = false;
        $this->assertFalse($baz == true);
    }

}
