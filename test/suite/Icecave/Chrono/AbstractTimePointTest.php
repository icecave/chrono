<?php
namespace Icecave\Chrono;

use PHPUnit_Framework_TestCase;
use Phake;

class AbstractTimePointTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->timePoint = Phake::partialMock('Icecave\Chrono\AbstractTimePoint');

        $this->before = Phake::partialMock('Icecave\Chrono\AbstractTimePoint');
        $this->same = Phake::partialMock('Icecave\Chrono\AbstractTimePoint');
        $this->after = Phake::partialMock('Icecave\Chrono\AbstractTimePoint');

        Phake::when($this->timePoint)
            ->unixTime()
            ->thenReturn(0);

        Phake::when($this->before)
            ->unixTime()
            ->thenReturn(-99);

        Phake::when($this->same)
            ->unixTime()
            ->thenReturn(0);

        Phake::when($this->after)
            ->unixTime()
            ->thenReturn(99);
    }

    public function testCompare()
    {
        $this->assertLessThan(0, $this->before->compare($this->timePoint));
        $this->assertGreaterThan(0, $this->timePoint->compare($this->before));

        $this->assertSame(0, $this->timePoint->compare($this->same));
        $this->assertSame(0, $this->same->compare($this->timePoint));

        $this->assertLessThan(0, $this->timePoint->compare($this->after));
        $this->assertGreaterThan(0, $this->after->compare($this->timePoint));
    }

    public function testIsEqualTo()
    {
        $this->assertFalse($this->timePoint->isEqualTo($this->before));
        $this->assertTrue($this->timePoint->isEqualTo($this->same));
        $this->assertFalse($this->timePoint->isEqualTo($this->after));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->timePoint->isNotEqualTo($this->before));
        $this->assertFalse($this->timePoint->isNotEqualTo($this->same));
        $this->assertTrue($this->timePoint->isNotEqualTo($this->after));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->timePoint->isGreaterThan($this->before));
        $this->assertFalse($this->timePoint->isGreaterThan($this->same));
        $this->assertFalse($this->timePoint->isGreaterThan($this->after));
    }

    public function testIsLessThan()
    {
        $this->assertFalse($this->timePoint->isLessThan($this->before));
        $this->assertFalse($this->timePoint->isLessThan($this->same));
        $this->assertTrue($this->timePoint->isLessThan($this->after));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->timePoint->isGreaterThanOrEqualTo($this->before));
        $this->assertTrue($this->timePoint->isGreaterThanOrEqualTo($this->same));
        $this->assertFalse($this->timePoint->isGreaterThanOrEqualTo($this->after));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse($this->timePoint->isLessThanOrEqualTo($this->before));
        $this->assertTrue($this->timePoint->isLessThanOrEqualTo($this->same));
        $this->assertTrue($this->timePoint->isLessThanOrEqualTo($this->after));
    }

    public function testDifferenceAsDuration()
    {
        Phake::when($this->timePoint)
            ->unixTime()
            ->thenReturn(12345);

        Phake::when($this->before)
            ->unixTime()
            ->thenReturn(12340);

        $duration = $this->timePoint->differenceAsDuration($this->before);

        $this->assertInstanceOf('Icecave\Chrono\Duration\Duration', $duration);
        $this->assertSame(5, $duration->totalSeconds());
    }
}
