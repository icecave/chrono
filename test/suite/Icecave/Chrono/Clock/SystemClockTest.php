<?php
namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\Time;
use Icecave\Chrono\TimeZone;
use PHPUnit_Framework_TestCase;
use Phake;
use Icecave\Isolator\Isolator;

class SystemClockTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_isolator = Phake::mock(get_class(Isolator::get()));
        // $this->_clock = new SystemClock($this->_isolator);
    }

    public function testFoo()
    {
        $this->assertTrue(true);
    }
    
}
