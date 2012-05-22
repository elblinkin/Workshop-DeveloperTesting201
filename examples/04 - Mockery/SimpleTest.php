<?php

use \Mockery as m;

class SimpleTest extends PHPUnit_Framework_TestCase {

    public function testSimpleMock() {
        $mock = m::mock('simple mock');
        $mock->shouldReceive('foo')->with(5, m::any())->once()->andReturn(10);
        $this->assertEquals(10, $mock->foo(5));
    }

    public function teardown() {
        m::close();
    }
}

