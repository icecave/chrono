<?php

namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Phake;
use PHPUnit\Framework\TestCase;

class AbstractIntervalTest extends TestCase
{
    public function setUp(): void
    {
        /*
                    A   B   C   D   E
        Interval 1: *****
        Interval 2:         *****
        Interval 3:     *****
        Interval 4:     *************
        */

        $this->pointA = new Date(2012, 1, 1);
        $this->pointB = new Date(2012, 1, 5);
        $this->pointB = new Date(2012, 1, 5);
        $this->pointC = new Date(2012, 1, 9);
        $this->pointD = new Date(2012, 1, 13);
        $this->pointE = new Date(2012, 1, 17);

        $this->interval1 = $this->createInterval($this->pointA, $this->pointB);
        $this->interval2 = $this->createInterval($this->pointC, $this->pointD);
        $this->interval3 = $this->createInterval($this->pointB, $this->pointC);
        $this->interval4 = $this->createInterval($this->pointB, $this->pointE);
    }

    public function createInterval($start, $end)
    {
        $interval = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');

        Phake::when($interval)
            ->start()
            ->thenReturn($start);

        Phake::when($interval)
            ->end()
            ->thenReturn($end);

        return $interval;
    }

    public function testIsEmpty()
    {
        $interval = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 1));
        $this->assertTrue($interval->isEmpty());

        $interval = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 2));
        $this->assertFalse($interval->isEmpty());
    }

    public function testCompareWithNotComparableException()
    {
        $this->expectException('Icecave\Parity\Exception\NotComparableException');
        $this->interval1->compare('foo');
    }

    public function testCompare()
    {
        $interval1 = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 2));
        $interval2 = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 3));
        $interval3 = $this->createInterval(new Date(2012, 1, 5), new Date(2012, 1, 6));

        $this->assertSame(0, $interval1->compare($interval1));
        $this->assertLessThan(0, $interval1->compare($interval2));
        $this->assertLessThan(0, $interval2->compare($interval3));
        $this->assertGreaterThan(0, $interval2->compare($interval1));
    }

    public function testIsEqualTo()
    {
        $this->assertTrue($this->interval1->isEqualTo($this->interval1));
        $this->assertTrue($this->interval2->isEqualTo($this->interval2));
        $this->assertFalse($this->interval1->isEqualTo($this->interval2));
        $this->assertFalse($this->interval1->isEqualTo($this->interval3));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->interval1->isNotEqualTo($this->interval2));
        $this->assertTrue($this->interval1->isNotEqualTo($this->interval3));
        $this->assertFalse($this->interval1->isNotEqualTo($this->interval1));
        $this->assertFalse($this->interval2->isNotEqualTo($this->interval2));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->interval2->isGreaterThan($this->interval1));
        $this->assertTrue($this->interval3->isGreaterThan($this->interval1));
        $this->assertFalse($this->interval1->isGreaterThan($this->interval2));
        $this->assertFalse($this->interval3->isGreaterThan($this->interval2));
    }

    public function testIsLessThan()
    {
        $this->assertTrue($this->interval1->isLessThan($this->interval2));
        $this->assertTrue($this->interval1->isLessThan($this->interval3));
        $this->assertFalse($this->interval3->isLessThan($this->interval1));
        $this->assertFalse($this->interval2->isLessThan($this->interval3));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->interval2->isGreaterThanOrEqualTo($this->interval2));
        $this->assertTrue($this->interval2->isGreaterThanOrEqualTo($this->interval3));
        $this->assertFalse($this->interval1->isGreaterThanOrEqualTo($this->interval2));
        $this->assertFalse($this->interval1->isGreaterThanOrEqualTo($this->interval3));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertTrue($this->interval2->isLessThanOrEqualTo($this->interval2));
        $this->assertTrue($this->interval3->isLessThanOrEqualTo($this->interval2));
        $this->assertFalse($this->interval2->isLessThanOrEqualTo($this->interval1));
        $this->assertFalse($this->interval3->isLessThanOrEqualTo($this->interval1));
    }

    public function testContains()
    {
        $interval = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 2));

        $this->assertFalse($interval->contains(new Date(2011, 12, 31)));
        $this->assertTrue($interval->contains(new Date(2012, 1, 1)));
        $this->assertFalse($interval->contains(new Date(2012, 1, 2)));
    }

    public function testEncompasses()
    {
        $this->assertTrue($this->interval1->encompasses($this->interval1));
        $this->assertFalse($this->interval1->encompasses($this->interval2));
        $this->assertFalse($this->interval1->encompasses($this->interval3));
        $this->assertFalse($this->interval1->encompasses($this->interval4));

        $this->assertFalse($this->interval2->encompasses($this->interval1));
        $this->assertTrue($this->interval2->encompasses($this->interval2));
        $this->assertFalse($this->interval2->encompasses($this->interval3));
        $this->assertFalse($this->interval2->encompasses($this->interval4));

        $this->assertFalse($this->interval3->encompasses($this->interval1));
        $this->assertFalse($this->interval3->encompasses($this->interval2));
        $this->assertTrue($this->interval3->encompasses($this->interval3));
        $this->assertFalse($this->interval3->encompasses($this->interval4));

        $this->assertFalse($this->interval4->encompasses($this->interval1));
        $this->assertTrue($this->interval4->encompasses($this->interval2));
        $this->assertTrue($this->interval4->encompasses($this->interval3));
        $this->assertTrue($this->interval4->encompasses($this->interval4));
    }

    public function testIntersects()
    {
        $this->assertTrue($this->interval1->intersects($this->interval1));
        $this->assertFalse($this->interval1->intersects($this->interval2));
        $this->assertFalse($this->interval1->intersects($this->interval3));
        $this->assertFalse($this->interval1->intersects($this->interval4));

        $this->assertFalse($this->interval2->intersects($this->interval1));
        $this->assertTrue($this->interval2->intersects($this->interval2));
        $this->assertFalse($this->interval2->intersects($this->interval3));
        $this->assertTrue($this->interval2->intersects($this->interval4));

        $this->assertFalse($this->interval3->intersects($this->interval1));
        $this->assertFalse($this->interval3->intersects($this->interval2));
        $this->assertTrue($this->interval3->intersects($this->interval3));
        $this->assertTrue($this->interval3->intersects($this->interval4));

        $this->assertFalse($this->interval4->intersects($this->interval1));
        $this->assertTrue($this->interval4->intersects($this->interval2));
        $this->assertTrue($this->interval4->intersects($this->interval3));
        $this->assertTrue($this->interval4->intersects($this->interval4));
    }

    public function testDuration()
    {
        $interval = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 2));
        $duration = $interval->duration();

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Duration', $duration);
        $this->assertSame(86400, $duration->totalSeconds());
    }

    public function testDurationEmptyInterval()
    {
        $interval = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 1));
        $duration = $interval->duration();

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Duration', $duration);
        $this->assertTrue($duration->isEmpty());
    }

    public function testPeriod()
    {
        $interval = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 2));
        $period   = $interval->period();

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Period', $period);
        $this->assertSame(86400, $period->approximateTotalSeconds());
    }

    public function testPeriodEmptyInterval()
    {
        $interval = $this->createInterval(new Date(2012, 1, 1), new Date(2012, 1, 1));
        $period   = $interval->period();

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Period', $period);
        $this->assertTrue($period->isEmpty());
    }

    public function testByYear()
    {
        $interval = new Interval(new Date(2010, 12, 25), new Date(2015, 12, 25));

        $expected = [
            new Year(2010),
            new Year(2011),
            new Year(2012),
            new Year(2013),
            new Year(2014),
        ];

        $this->assertEquals($expected, iterator_to_array($interval->byYear(), true));
    }

    public function testByMonth()
    {
        $interval = new Interval(new Date(2010, 12, 25), new Date(2011, 2, 26));

        $expected = [
            new Month(new Year(2010), 12),
            new Month(new Year(2011), 1),
            new Month(new Year(2011), 2),
        ];

        $this->assertEquals($expected, iterator_to_array($interval->byMonth(), true));
    }

    public function testByDay()
    {
        $interval = new Interval(new Date(2010, 12, 30), new Date(2011, 1, 3));

        $expected = [
            new Date(2010, 12, 30),
            new Date(2010, 12, 31),
            new Date(2011, 1, 1),
            new Date(2011, 1, 2),
        ];

        $this->assertEquals($expected, iterator_to_array($interval->byDay(), true));
    }

    public function testByHour()
    {
        $interval = new Interval(new DateTime(2010, 12, 25, 10, 20, 30), new DateTime(2010, 12, 25, 15, 20, 30));

        $expected = [
            new DateTime(2010, 12, 25, 10, 20, 30),
            new DateTime(2010, 12, 25, 11, 20, 30),
            new DateTime(2010, 12, 25, 12, 20, 30),
            new DateTime(2010, 12, 25, 13, 20, 30),
            new DateTime(2010, 12, 25, 14, 20, 30),
        ];

        $this->assertEquals($expected, iterator_to_array($interval->byHour(), true));
    }

    public function testByMinute()
    {
        $interval = new Interval(new DateTime(2010, 12, 25, 10, 20, 30), new DateTime(2010, 12, 25, 10, 25, 30));

        $expected = [
            new DateTime(2010, 12, 25, 10, 20, 30),
            new DateTime(2010, 12, 25, 10, 21, 30),
            new DateTime(2010, 12, 25, 10, 22, 30),
            new DateTime(2010, 12, 25, 10, 23, 30),
            new DateTime(2010, 12, 25, 10, 24, 30),
        ];

        $this->assertEquals($expected, iterator_to_array($interval->byMinute(), true));
    }

    public function testBySecond()
    {
        $interval = new Interval(new DateTime(2010, 12, 25, 10, 20, 30), new DateTime(2010, 12, 25, 10, 20, 35));

        $expected = [
            new DateTime(2010, 12, 25, 10, 20, 30),
            new DateTime(2010, 12, 25, 10, 20, 31),
            new DateTime(2010, 12, 25, 10, 20, 32),
            new DateTime(2010, 12, 25, 10, 20, 33),
            new DateTime(2010, 12, 25, 10, 20, 34),
        ];

        $this->assertEquals($expected, iterator_to_array($interval->bySecond(), true));
    }
}
