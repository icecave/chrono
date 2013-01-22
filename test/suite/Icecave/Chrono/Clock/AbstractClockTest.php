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
        $this->_clock = Phake::partialMock(__NAMESPACE__ . '\AbstractClock');

        $this->_timeZone = new TimeZone(36000, true);

        Phake::when($this->_clock)
            ->currentLocalTimeInfo()
            ->thenReturn(array(10, 20, 13, 20, 11, 2013, '<unused>', '<unused>', 1, 36000));

        Phake::when($this->_clock)
            ->currentUtcTimeInfo()
            ->thenReturn(array(1, 2, 3, 4, 5, 2011, '<unused>', '<unused>', 0, 0)); // Intentially set vastly different from localTimeInfo to catch potential errors.
    }

    public function verifyLocalClockSuspended()
    {
        Phake::inOrder(
            Phake::verify($this->_clock, Phake::atLeast(1))->suspend(),
            Phake::verify($this->_clock, Phake::times(1))->currentLocalTimeInfo(),
            Phake::verify($this->_clock, Phake::atLeast(1))->resume()
        );
    }

    public function verifyUtcClockSuspended()
    {
        Phake::inOrder(
            Phake::verify($this->_clock, Phake::atLeast(1))->suspend(),
            Phake::verify($this->_clock, Phake::times(1))->currentUtcTimeInfo(),
            Phake::verify($this->_clock, Phake::atLeast(1))->resume()
        );
    }

    public function testLocalTime()
    {
        $result = $this->_clock->localTime();
        $expected = new Time(13, 20, 10, $this->_timeZone);
        $this->assertEquals($expected, $result);

        $this->verifyLocalClockSuspended();
    }

    public function testLocalDateTime()
    {
        $result = $this->_clock->localDateTime();
        $expected = new DateTime(2013, 11, 20, 13, 20, 10, $this->_timeZone);
        $this->assertEquals($expected, $result);

        $this->verifyLocalClockSuspended();
    }

    public function testLocalDate()
    {
        $result = $this->_clock->localDate();
        $expected = new Date(2013, 11, 20, $this->_timeZone);
        $this->assertEquals($expected, $result);

        $this->verifyLocalClockSuspended();
    }

    public function testLocalMonth()
    {
        $result = $this->_clock->localMonth();
        $expected = new Month(new Year(2013), 11);
        $this->assertEquals($expected, $result);

        $this->verifyLocalClockSuspended();
    }

    public function testLocalYear()
    {
        $result = $this->_clock->localYear();
        $expected = new Year(2013);
        $this->assertEquals($expected, $result);

        $this->verifyLocalClockSuspended();
    }

    public function testUtcTime()
    {
        $result = $this->_clock->utcTime();
        $expected = new Time(3, 2, 1);
        $this->assertEquals($expected, $result);

        $this->verifyUtcClockSuspended();
    }

    public function testUtcDateTime()
    {
        $result = $this->_clock->utcDateTime();
        $expected = new DateTime(2011, 5, 4, 3, 2, 1);
        $this->assertEquals($expected, $result);

        $this->verifyUtcClockSuspended();
    }

    public function testUtcDate()
    {
        $result = $this->_clock->utcDate();
        $expected = new Date(2011, 5, 4);
        $this->assertEquals($expected, $result);

        $this->verifyUtcClockSuspended();
    }

    public function testUtcMonth()
    {
        $result = $this->_clock->utcMonth();
        $expected = new Month(new Year(2011), 5);
        $this->assertEquals($expected, $result);

        $this->verifyUtcClockSuspended();
    }

    public function testUtcYear()
    {
        $result = $this->_clock->utcYear();
        $expected = new Year(2011);
        $this->assertEquals($expected, $result);

        $this->verifyUtcClockSuspended();
    }

    public function testSuspend()
    {
        $this->_clock->suspend();

        $this->assertTrue($this->_clock->isSuspended());

        // Try localDateTime twice ...
        $expected = new DateTime(2013, 11, 20, 13, 20, 10, $this->_timeZone);
        $result = $this->_clock->localDateTime();
        $this->assertEquals($expected, $result);

        $result = $this->_clock->localDateTime();
        $this->assertEquals($expected, $result);

        // Only calls implementation once ...
        Phake::verify($this->_clock, Phake::times(1))->currentLocalTimeInfo();

        // Try utcDateTime twice ...
        $expected = new DateTime(2011, 5, 4, 3, 2, 1);
        $result = $this->_clock->utcDateTime();
        $this->assertEquals($expected, $result);

        $result = $this->_clock->utcDateTime();
        $this->assertEquals($expected, $result);

        // Only calls implementation once ...
        Phake::verify($this->_clock, Phake::times(1))->currentUtcTimeInfo();
    }

    public function testSuspendStacking()
    {
        $this->_clock->suspend();
        $this->assertTrue($this->_clock->isSuspended());

        $this->_clock->suspend();
        $this->assertTrue($this->_clock->isSuspended());

        $this->_clock->resume();
        $this->assertTrue($this->_clock->isSuspended());

        $this->_clock->resume();
        $this->assertFalse($this->_clock->isSuspended());
    }

    public function testResumeWithLocalTime()
    {
        $this->_clock->resume();

        $this->assertFalse($this->_clock->isSuspended());

        // Try localDateTime twice ...
        $expected = new DateTime(2013, 11, 20, 13, 20, 10, $this->_timeZone);
        $result = $this->_clock->localDateTime();
        $this->assertEquals($expected, $result);

        $result = $this->_clock->localDateTime();
        $this->assertEquals($expected, $result);

        // Calls implementation twice ...
        Phake::verify($this->_clock, Phake::times(2))->currentLocalTimeInfo();
    }

    public function testResumeWithUtcTime()
    {
        $this->_clock->resume();

        $this->assertFalse($this->_clock->isSuspended());

        // Try utcDateTime twice ...
        $expected = new DateTime(2011, 5, 4, 3, 2, 1);
        $result = $this->_clock->utcDateTime();
        $this->assertEquals($expected, $result);

        $result = $this->_clock->utcDateTime();
        $this->assertEquals($expected, $result);

        // Calls implementation twice once ...
        Phake::verify($this->_clock, Phake::times(2))->currentUtcTimeInfo();
    }
}
