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
        $this->same   = Phake::partialMock('Icecave\Chrono\AbstractTimePoint');
        $this->after  = Phake::partialMock('Icecave\Chrono\AbstractTimePoint');

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

    public function testCompareWithNotComparableException()
    {
        $this->setExpectedException('Icecave\Parity\Exception\NotComparableException');
        $this->timePoint->compare('foo');
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

    public function testDifferenceAsSeconds()
    {
        Phake::when($this->timePoint)
            ->unixTime()
            ->thenReturn(12345);

        Phake::when($this->before)
            ->unixTime()
            ->thenReturn(12340);

        $duration = $this->timePoint->differenceAsSeconds($this->before);

        $this->assertSame(5, $duration);
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

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Duration', $duration);
        $this->assertSame(5, $duration->totalSeconds());
    }

    public function testDifferenceAsPeriod()
    {
        $a = DateTime::fromIsoString('2012-01-02T10:20:30+10:00');
        $b = DateTime::fromIsoString('2013-03-05T14:25:36+10:00');

        $result = $b->differenceAsPeriod($a);

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Period', $result);
        $this->assertSame('1y 2m 3d 04:05:06', $result->string());
    }

    /**
     * @dataProvider isoDaysOfWeek()
     */
    public function testIsoDayOfWeek(DateInterface $date, $expected)
    {
        $this->assertSame($expected, $date->isoDayOfWeek());
    }

    public function isoDaysOfWeek()
    {
        return array(
            array(new Date(2013, 8,  5),   1),
            array(new Date(2013, 8,  6),   2),
            array(new Date(2013, 8,  7),   3),
            array(new Date(2013, 8,  8),   4),
            array(new Date(2013, 8,  9),   5),
            array(new Date(2013, 8, 10),   6),
            array(new Date(2013, 8, 11),   7),
        );
    }

    /**
     * @dataProvider numericDaysOfWeek()
     */
    public function testNumericDayOfWeek(DateInterface $date, $expected)
    {
        $this->assertSame($expected, $date->numericDayOfWeek());
    }

    public function numericDaysOfWeek()
    {
        return array(
            array(new Date(2013, 8,  5),   1),
            array(new Date(2013, 8,  6),   2),
            array(new Date(2013, 8,  7),   3),
            array(new Date(2013, 8,  8),   4),
            array(new Date(2013, 8,  9),   5),
            array(new Date(2013, 8, 10),   6),
            array(new Date(2013, 8, 11),   0),
        );
    }
}
