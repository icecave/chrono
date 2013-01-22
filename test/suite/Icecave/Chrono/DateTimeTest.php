<?php
namespace Icecave\Chrono;

use Phake;
use PHPUnit_Framework_TestCase;

class DateTimeTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_dateTime = new DateTime(2013, 2, 1, 10, 20, 30);
    }

    public function testNormalization()
    {
        $time = new DateTime(2013, 1, 32, 10, 20, 70);
        $this->assertSame('2013-02-01 10:21:10+00:00', $time->isoString());
    }
}
