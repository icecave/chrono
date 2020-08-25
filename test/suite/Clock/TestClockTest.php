<?php

namespace Icecave\Chrono\Clock;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Month;
use Icecave\Chrono\Interval\Year;
use Icecave\Chrono\TimeOfDay;
use Icecave\Chrono\Timer\Timer;
use Icecave\Chrono\TimeSpan\Duration;
use Icecave\Chrono\TimeZone;
use Phake;
use PHPUnit\Framework\TestCase;

class TestClockTest extends TestCase
{
    public function setUp(): void
    {
        $this->localDateTime = DateTime::fromIsoString('2001-01-01T01:01:01+01:00');
        $this->isolator      = Phake::mock('Icecave\Isolator\Isolator');
        $this->clock         = new TestClock($this->localDateTime, $this->isolator);

        Phake::when($this->isolator)->function_exists('pcntl_signal_dispatch')->thenReturn(true);
    }

    public function testConstructor()
    {
        $this->assertSame($this->localDateTime, $this->clock->localDateTime());
    }

    public function testConstructorDefaults()
    {
        $this->clock = new TestClock();

        $this->assertEquals(DateTime::fromUnixTime(0), $this->clock->localDateTime());
        $this->assertFalse($this->clock->isSuspended());
    }

    public function testAddTime()
    {
        $this->clock->addTime(Duration::fromComponents(0, 1, 1, 1, 1));

        $this->assertEquals(DateTime::fromIsoString('2001-01-02T02:02:02+01:00'), $this->clock->localDateTime());
    }

    public function testSubtractTime()
    {
        $this->clock->subtractTime(Duration::fromComponents(0, 1, 1, 1, 1));

        $this->assertEquals(DateTime::fromIsoString('2000-12-31T00:00:00+01:00'), $this->clock->localDateTime());
    }

    public function testSetLocalDateTime()
    {
        $this->localDateTime = DateTime::fromIsoString('2002-02-02T02:02:02+02:00');
        $this->clock->setLocalDateTime($this->localDateTime);

        $this->assertSame($this->localDateTime, $this->clock->localDateTime());
    }

    public function testLocalTime()
    {
        $this->assertEquals(TimeOfDay::fromIsoString('01:01:01+01:00'), $this->clock->localTime());
    }

    public function testLocalDate()
    {
        $this->assertEquals(Date::fromIsoString('2001-01-01+01:00'), $this->clock->localDate());
    }

    public function testLocalMonth()
    {
        $this->assertEquals(new Month(new Year(2001), 1), $this->clock->localMonth());
    }

    public function testLocalYear()
    {
        $this->assertEquals(new Year(2001), $this->clock->localYear());
    }

    public function testUtcTime()
    {
        $this->assertEquals(TimeOfDay::fromIsoString('00:01:01+00:00'), $this->clock->utcTime());
    }

    public function testUtcDateTime()
    {
        $this->assertEquals(DateTime::fromIsoString('2001-01-01T00:01:01+00:00'), $this->clock->utcDateTime());
    }

    public function testUtcDate()
    {
        $this->assertEquals(Date::fromIsoString('2001-01-01+00:00'), $this->clock->utcDate());
    }

    public function testUtcMonth()
    {
        $this->assertEquals(new Month(new Year(2001), 1), $this->clock->utcMonth());
    }

    public function testUtcYear()
    {
        $this->assertEquals(new Year(2001), $this->clock->utcYear());
    }

    public function testTimeZone()
    {
        $this->assertEquals(TimeZone::fromIsoString('+01:00'), $this->clock->timeZone());
    }

    public function testUnixTime()
    {
        $this->assertSame(978307261, $this->clock->unixTime());
    }

    public function testUnixTimeAsFloat()
    {
        $this->assertEqualsWithDelta(978307261.0, $this->clock->unixTimeAsFloat(), 0.0000000001);
    }

    public function testSleep()
    {
        $this->assertTrue($this->clock->sleep(111));
        $this->assertEquals(DateTime::fromIsoString('2001-01-01T01:02:52+01:00'), $this->clock->localDateTime());
        Phake::verify($this->isolator)->pcntl_signal_dispatch();
    }

    public function testSleepNoSignal()
    {
        $this->assertTrue($this->clock->sleep(111, false));
        $this->assertEquals(DateTime::fromIsoString('2001-01-01T01:02:52+01:00'), $this->clock->localDateTime());
        Phake::verify($this->isolator, Phake::never())->pcntl_signal_dispatch(Phake::anyParameters());
    }

    public function testSleepWithNoPcntl()
    {
        Phake::when($this->isolator)->function_exists('pcntl_signal_dispatch')->thenReturn(false);

        $this->assertTrue($this->clock->sleep(111, true));
        $this->assertEquals(DateTime::fromIsoString('2001-01-01T01:02:52+01:00'), $this->clock->localDateTime());
        Phake::verify($this->isolator, Phake::never())->pcntl_signal_dispatch(Phake::anyParameters());
    }

    public function testSleepUntil()
    {
        $timePoint = DateTime::fromIsoString('2012-12-12T12:12:12+01:00');

        $this->assertTrue($this->clock->sleepUntil($timePoint));
        $this->assertEquals($timePoint, $this->clock->localDateTime());
        Phake::verify($this->isolator)->pcntl_signal_dispatch();
    }

    public function testSleepUntilNoSignal()
    {
        $timePoint = DateTime::fromIsoString('2012-12-12T12:12:12+01:00');

        $this->assertTrue($this->clock->sleepUntil($timePoint, false));
        $this->assertEquals($timePoint, $this->clock->localDateTime());
        Phake::verify($this->isolator, Phake::never())->pcntl_signal_dispatch(Phake::anyParameters());
    }

    public function testSleepUntilWithNoPcntl()
    {
        Phake::when($this->isolator)->function_exists('pcntl_signal_dispatch')->thenReturn(false);
        $timePoint = DateTime::fromIsoString('2012-12-12T12:12:12+01:00');

        $this->assertTrue($this->clock->sleepUntil($timePoint, true));
        $this->assertEquals($timePoint, $this->clock->localDateTime());
        Phake::verify($this->isolator, Phake::never())->pcntl_signal_dispatch(Phake::anyParameters());
    }

    public function testCreateTime()
    {
        $this->assertEquals(new Timer($this->clock), $this->clock->createTimer());
    }

    public function testSuspendResume()
    {
        $this->clock->suspend();

        $this->assertTrue($this->clock->isSuspended());

        $this->clock->resume();

        $this->assertFalse($this->clock->isSuspended());
    }
}
