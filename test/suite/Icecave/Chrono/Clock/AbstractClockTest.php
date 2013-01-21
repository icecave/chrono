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

class AbstractClockTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_timeZone = new TimeZone(36000, false);

        $this->_clock = Phake::partialMock(__NAMESPACE__ . '\AbstractClock');

        Phake::when($this->_clock)
            ->timeZone()
            ->thenReturn($this->_timeZone);

        Phake::when($this->_clock)
            ->localTimeInfo()
            ->thenReturn(array(10, 20, 13, 20, 11, 2013));

        Phake::when($this->_clock)
            ->utcTimeInfo()
            ->thenReturn(array(1, 2, 3, 4, 5, 2011)); // Intentially set vastly different from localTimeInfo to catch potential errors.
    }

    public function testLocalTime()
    {
        $result = $this->_clock->localTime();
        $expected = new Time(13, 20, 10, $this->_timeZone);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->localTimeInfo();
    }

    public function testLocalDateTime()
    {
        $result = $this->_clock->localDateTime();
        $expected = new DateTime(2013, 11, 20, 13, 20, 10, $this->_timeZone);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->localTimeInfo();
    }

    public function testLocalDate()
    {
        $result = $this->_clock->localDate();
        $expected = new Date(2013, 11, 20);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->localTimeInfo();
    }

    public function testLocalMonth()
    {
        $result = $this->_clock->localMonth();
        $expected = new Month(new Year(2013), 11);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->localTimeInfo();
    }

    public function testLocalYear()
    {
        $result = $this->_clock->localYear();
        $expected = new Year(2013);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->localTimeInfo();
    }

    public function testUtcTime()
    {
        $result = $this->_clock->utcTime();
        $expected = new Time(3, 2, 1);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->utcTimeInfo();
    }

    public function testUtcDateTime()
    {
        $result = $this->_clock->utcDateTime();
        $expected = new DateTime(2011, 5, 4, 3, 2, 1);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->utcTimeInfo();
    }

    public function testUtcDate()
    {
        $result = $this->_clock->utcDate();
        $expected = new Date(2011, 5, 4);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->utcTimeInfo();
    }

    public function testUtcMonth()
    {
        $result = $this->_clock->utcMonth();
        $expected = new Month(new Year(2011), 5);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->utcTimeInfo();
    }

    public function testUtcYear()
    {
        $result = $this->_clock->utcYear();
        $expected = new Year(2011);
        $this->assertEquals($expected, $result);

        Phake::verify($this->_clock)->utcTimeInfo();
    }
}
