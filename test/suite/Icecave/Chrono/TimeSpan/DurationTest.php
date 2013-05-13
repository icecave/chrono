<?php
namespace Icecave\Chrono\TimeSpan;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;
use Phake;
use PHPUnit_Framework_TestCase;

class DurationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->duration = Duration::fromComponents(1, 2, 3, 4, 5);

        $this->before = Duration::fromComponents(1, 2, 3, 4, 4);
        $this->same = Duration::fromComponents(1, 2, 3, 4, 5);
        $this->after = Duration::fromComponents(1, 2, 3, 4, 6);
    }

    public function testWeeks()
    {
        $this->assertSame(1, $this->duration->weeks());
    }

    public function testDays()
    {
        $this->assertSame(2, $this->duration->days());
    }

    public function testHours()
    {
        $this->assertSame(3, $this->duration->hours());
    }

    public function testMinutes()
    {
        $this->assertSame(4, $this->duration->minutes());
    }

    public function testSeconds()
    {
        $this->assertSame(5, $this->duration->seconds());
    }

    public function testTotalDays()
    {
        $this->assertSame(9, $this->duration->totalDays());
    }

    public function testTotalHours()
    {
        $this->assertSame(219, $this->duration->totalHours());
    }

    public function testTotalMinutes()
    {
        $this->assertSame(13144, $this->duration->totalMinutes());
    }

    public function testTotalSeconds()
    {
        $this->assertSame(788645, $this->duration->totalSeconds());
    }

    public function testIsEmpty()
    {
        $this->assertFalse($this->duration->isEmpty());

        $duration = new Duration;

        $this->assertTrue($duration->isEmpty());
    }

    public function testCompare()
    {
        $this->assertGreaterThan(0, $this->duration->compare($this->before));
        $this->assertSame(0, $this->duration->compare($this->same));
        $this->assertLessThan(0, $this->duration->compare($this->after));
    }

    public function testIsEqualTo()
    {
        $this->assertFalse($this->duration->isEqualTo($this->before));
        $this->assertTrue($this->duration->isEqualTo($this->same));
        $this->assertFalse($this->duration->isEqualTo($this->after));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->duration->isNotEqualTo($this->before));
        $this->assertFalse($this->duration->isNotEqualTo($this->same));
        $this->assertTrue($this->duration->isNotEqualTo($this->after));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->duration->isGreaterThan($this->before));
        $this->assertFalse($this->duration->isGreaterThan($this->same));
        $this->assertFalse($this->duration->isGreaterThan($this->after));
    }

    public function testIsLessThan()
    {
        $this->assertFalse($this->duration->isLessThan($this->before));
        $this->assertFalse($this->duration->isLessThan($this->same));
        $this->assertTrue($this->duration->isLessThan($this->after));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->duration->isGreaterThanOrEqualTo($this->before));
        $this->assertTrue($this->duration->isGreaterThanOrEqualTo($this->same));
        $this->assertFalse($this->duration->isGreaterThanOrEqualTo($this->after));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse($this->duration->isLessThanOrEqualTo($this->before));
        $this->assertTrue($this->duration->isLessThanOrEqualTo($this->same));
        $this->assertTrue($this->duration->isLessThanOrEqualTo($this->after));
    }

    public function testInverse()
    {
        $this->assertSame(-788645, $this->duration->inverse()->totalSeconds());
    }

    public function testResolveToSeconds()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $this->assertSame(788645, $this->duration->resolveToSeconds($timePoint));

        Phake::verifyNoInteraction($timePoint);
    }

    public function testResolveToDuration()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $this->assertSame($this->duration, $this->duration->resolveToDuration($timePoint));

        Phake::verifyNoInteraction($timePoint);
    }

    public function testResolveToPeriod()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $result = $this->duration->resolveToPeriod($timePoint);
        $expected = new Period(0, 0, 9, 3, 4, 5);

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Period', $result);
        $this->assertSame(0, $expected->compare($result));

        Phake::verifyNoInteraction($timePoint);
    }

    public function testResolveToInterval()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->duration->resolveToInterval($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\Interval\IntervalInterface', $result);
        $this->assertSame('2012-01-02T10:20:30+10:00', $result->start()->isoString());
        $this->assertSame('2012-01-11T13:24:35+10:00', $result->end()->isoString());
    }

    public function testResolveToTimePoint()
    {
        $timeZone = new TimeZone(36000);
        $timePoint = new DateTime(2012, 1, 2, 10, 20, 30, $timeZone);

        $result = $this->duration->resolveToTimePoint($timePoint);

        $this->assertInstanceOf('Icecave\Chrono\TimePointInterface', $result);
        $this->assertSame('2012-01-11T13:24:35+10:00', $result->isoString());
    }

    public function testString()
    {
        $this->assertSame('1w 2d 03:04:05', $this->duration->string());
        $this->assertSame('1w 2d 03:04:05', $this->duration->__toString());
    }
}
