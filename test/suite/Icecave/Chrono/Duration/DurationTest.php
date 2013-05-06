<?php
namespace Icecave\Chrono\Duration;

use PHPUnit_Framework_TestCase;
use Phake;

/**
 * @covers Icecave\Chrono\Duration\Duration
 * @covers Icecave\Chrono\Duration\AbstractDuration
 */
class DurationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->duration = Duration::fromComponents(1, 2, 3, 4, 5);
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

    public function testResolve()
    {
        $timePoint = Phake::mock('Icecave\Chrono\TimePointInterface');

        $this->assertSame(788645, $this->duration->resolve($timePoint));

        Phake::verifyNoInteraction($timePoint);
    }
}
