<?php
namespace Icecave\Chrono;

use Phake;
use PHPUnit_Framework_TestCase;

class TimeTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_time = new Time(10, 20, 30);
    }

    public function testNormalization()
    {
        $time = new Time(10, 20, 70);
        $this->assertSame('10:21:10', $time->isoString());
    }
}
