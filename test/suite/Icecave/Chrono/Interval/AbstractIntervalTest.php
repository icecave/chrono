<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit_Framework_TestCase;
use Phake;

class AbstractIntervalTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
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
}
