<?php
namespace Icecave\Chrono\TimeSpan;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;
use Phake;
use PHPUnit_Framework_TestCase;

class PeriodTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->period = new Period(1, 2, 3, 4, 5, 6);

        $this->before = new Period(1, 2, 3, 4, 5, 5);
        $this->same = new Period(1, 2, 3, 4, 5, 6);
        $this->after = new Period(1, 2, 3, 4, 5, 7);
    }

    public function testYears()
    {
        $this->assertSame(1, $this->period->years());
    }

    public function testMonths()
    {
        $this->assertSame(2, $this->period->months());
    }

    public function testDays()
    {
        $this->assertSame(3, $this->period->days());
    }

    public function testHours()
    {
        $this->assertSame(4, $this->period->hours());
    }

    public function testMinutes()
    {
        $this->assertSame(5, $this->period->minutes());
    }

    public function testSeconds()
    {
        $this->assertSame(6, $this->period->seconds());
    }

    public function testApproximateTotalSeconds()
    {
        $this->assertSame(37091106, $this->period->approximateTotalSeconds());
    }

    public function testCompare()
    {
        $this->assertGreaterThan(0, $this->period->compare($this->before));
        $this->assertSame(0, $this->period->compare($this->same));
        $this->assertLessThan(0, $this->period->compare($this->after));
    }

    public function testIsEqualTo()
    {
        $this->assertFalse($this->period->isEqualTo($this->before));
        $this->assertTrue($this->period->isEqualTo($this->same));
        $this->assertFalse($this->period->isEqualTo($this->after));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->period->isNotEqualTo($this->before));
        $this->assertFalse($this->period->isNotEqualTo($this->same));
        $this->assertTrue($this->period->isNotEqualTo($this->after));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->period->isGreaterThan($this->before));
        $this->assertFalse($this->period->isGreaterThan($this->same));
        $this->assertFalse($this->period->isGreaterThan($this->after));
    }

    public function testIsLessThan()
    {
        $this->assertFalse($this->period->isLessThan($this->before));
        $this->assertFalse($this->period->isLessThan($this->same));
        $this->assertTrue($this->period->isLessThan($this->after));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->period->isGreaterThanOrEqualTo($this->before));
        $this->assertTrue($this->period->isGreaterThanOrEqualTo($this->same));
        $this->assertFalse($this->period->isGreaterThanOrEqualTo($this->after));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse($this->period->isLessThanOrEqualTo($this->before));
        $this->assertTrue($this->period->isLessThanOrEqualTo($this->same));
        $this->assertTrue($this->period->isLessThanOrEqualTo($this->after));
    }

    public function testIsEmpty()
    {
        $this->assertFalse($this->period->isEmpty());

        $period = new Period;

        $this->assertTrue($period->isEmpty());
    }

    public function testInverse()
    {
        $result = $this->period->inverse();

        $this->assertSame(-1, $result->years());
        $this->assertSame(-2, $result->months());
        $this->assertSame(-3, $result->days());
        $this->assertSame(-4, $result->hours());
        $this->assertSame(-5, $result->minutes());
        $this->assertSame(-6, $result->seconds());
    }

    public function testResolveToSeconds()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $this->assertSame(36993906, $this->period->resolveToSeconds($timePoint));
    }

    public function testResolveToDuration()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $duration = $this->period->resolveToDuration($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Duration', $duration);
        $this->assertSame(36993906, $duration->totalSeconds());
    }

    public function testResolveToPeriod()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $this->assertSame($this->period, $this->period->resolveToPeriod($timePoint));

        Phake::verifyNoInteraction($timePoint);
    }

    public function testResolveToInterval()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->period->resolveToInterval($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\Interval\IntervalInterface', $result);
        $this->assertSame('2012-01-02T10:20:30+10:00', $result->start()->isoString());
        $this->assertSame('2013-03-05T14:25:36+10:00', $result->end()->isoString());
    }

    public function testResolveToTimePoint()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->period->resolveToTimePoint($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\TimePointInterface', $result);
        $this->assertSame('2013-03-05T14:25:36+10:00', $result->isoString());
    }
}
