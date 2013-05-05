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

        $this->interval1 = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');
        $this->interval2 = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');
        $this->interval3 = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');
        $this->interval4 = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');

        $this->pointA = new Date(2012, 1, 1);
        $this->pointB = new Date(2012, 1, 5);
        $this->pointC = new Date(2012, 1, 9);
        $this->pointD = new Date(2012, 1, 13);
        $this->pointE = new Date(2012, 1, 17);

        Phake::when($this->interval1)
            ->start()
            ->thenReturn($this->pointA);

        Phake::when($this->interval1)
            ->end()
            ->thenReturn($this->pointB);

        Phake::when($this->interval2)
            ->start()
            ->thenReturn($this->pointC);

        Phake::when($this->interval2)
            ->end()
            ->thenReturn($this->pointD);

        Phake::when($this->interval3)
            ->start()
            ->thenReturn($this->pointB);

        Phake::when($this->interval3)
            ->end()
            ->thenReturn($this->pointC);

        Phake::when($this->interval4)
            ->start()
            ->thenReturn($this->pointB);

        Phake::when($this->interval4)
            ->end()
            ->thenReturn($this->pointE);
    }

    public function testIsEmpty()
    {
        $this->assertFalse($this->interval1->isEmpty());

        Phake::when($this->interval1)
            ->end()
            ->thenReturn($this->pointA);

        $this->assertTrue($this->interval1->isEmpty());
    }

    public function testCompare()
    {
        $this->assertLessThan(0, $this->interval1->compare($this->interval2));
        $this->assertGreaterThan(0, $this->interval2->compare($this->interval1));
    }

    public function testCompareSameStart()
    {
        Phake::when($this->interval2)
            ->start()
            ->thenReturn($this->pointA);

        $this->assertLessThan(0, $this->interval1->compare($this->interval2));
        $this->assertGreaterThan(0, $this->interval2->compare($this->interval1));
    }

    public function testCompareSelf()
    {
        $this->assertSame(0, $this->interval1->compare($this->interval1));
    }

    public function testContains()
    {
        $this->assertTrue($this->interval1->contains(new Date(2012, 1, 2)));
        $this->assertFalse($this->interval1->contains($this->pointC));
    }

    public function testContainsEdges()
    {
        $this->assertTrue($this->interval1->contains($this->pointA));
        $this->assertTrue($this->interval1->contains($this->pointB));
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
        $this->assertTrue($this->interval1->intersects($this->interval3));
        $this->assertTrue($this->interval1->intersects($this->interval4));

        $this->assertFalse($this->interval2->intersects($this->interval1));
        $this->assertTrue($this->interval2->intersects($this->interval2));
        $this->assertTrue($this->interval2->intersects($this->interval3));
        $this->assertTrue($this->interval2->intersects($this->interval4));

        $this->assertTrue($this->interval3->intersects($this->interval1));
        $this->assertTrue($this->interval3->intersects($this->interval2));
        $this->assertTrue($this->interval3->intersects($this->interval3));
        $this->assertTrue($this->interval3->intersects($this->interval4));

        $this->assertTrue($this->interval4->intersects($this->interval1));
        $this->assertTrue($this->interval4->intersects($this->interval2));
        $this->assertTrue($this->interval4->intersects($this->interval3));
        $this->assertTrue($this->interval4->intersects($this->interval4));
    }
}
