<?php
namespace Icecave\Chrono\TimeSpan;

use PHPUnit_Framework_TestCase;
use Phake;

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
        $duration1 = new Duration(10);
        $duration2 = new Duration(20);

        $this->assertSame(0, $duration1->compare($duration1));
        $this->assertLessThan(0, $duration1->compare($duration2));
        $this->assertGreaterThan(0, $duration2->compare($duration1));
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

    public function testResolve()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $this->assertSame(788645, $this->duration->resolve($timePoint));

        Phake::verifyNoInteraction($timePoint);
    }
}
