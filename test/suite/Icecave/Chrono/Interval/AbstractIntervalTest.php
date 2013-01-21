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

        $this->_interval1 = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');
        $this->_interval2 = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');
        $this->_interval3 = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');
        $this->_interval4 = Phake::partialMock(__NAMESPACE__ . '\AbstractInterval');

        $this->_pointA = new Date(2012, 1, 1);
        $this->_pointB = new Date(2012, 1, 5);
        $this->_pointC = new Date(2012, 1, 9);
        $this->_pointD = new Date(2012, 1, 13);
        $this->_pointE = new Date(2012, 1, 17);

        Phake::when($this->_interval1)
            ->start()
            ->thenReturn($this->_pointA);

        Phake::when($this->_interval1)
            ->end()
            ->thenReturn($this->_pointB);

        Phake::when($this->_interval2)
            ->start()
            ->thenReturn($this->_pointC);

        Phake::when($this->_interval2)
            ->end()
            ->thenReturn($this->_pointD);

        Phake::when($this->_interval3)
            ->start()
            ->thenReturn($this->_pointB);

        Phake::when($this->_interval3)
            ->end()
            ->thenReturn($this->_pointC);

        Phake::when($this->_interval4)
            ->start()
            ->thenReturn($this->_pointB);

        Phake::when($this->_interval4)
            ->end()
            ->thenReturn($this->_pointE);
    }

    public function testIsEmpty()
    {
        $this->assertFalse($this->_interval1->isEmpty());

        Phake::when($this->_interval1)
            ->end()
            ->thenReturn($this->_pointA);

        $this->assertTrue($this->_interval1->isEmpty());
    }

    public function testCompare()
    {
        $this->assertLessThan(0, $this->_interval1->compare($this->_interval2));
        $this->assertGreaterThan(0, $this->_interval2->compare($this->_interval1));
    }

    public function testCompareSameStart()
    {
        Phake::when($this->_interval2)
            ->start()
            ->thenReturn($this->_pointA);

        $this->assertLessThan(0, $this->_interval1->compare($this->_interval2));
        $this->assertGreaterThan(0, $this->_interval2->compare($this->_interval1));
    }

    public function testCompareSelf()
    {
        $this->assertSame(0, $this->_interval1->compare($this->_interval1));
    }

    public function testContains()
    {
        $this->assertTrue($this->_interval1->contains(new Date(2012, 1, 2)));
        $this->assertFalse($this->_interval1->contains($this->_pointC));
    }

    public function testContainsEdges()
    {
        $this->assertTrue($this->_interval1->contains($this->_pointA));
        $this->assertTrue($this->_interval1->contains($this->_pointB));
    }

    public function testEncompasses()
    {
        $this->assertTrue($this->_interval1->encompasses($this->_interval1));
        $this->assertFalse($this->_interval1->encompasses($this->_interval2));
        $this->assertFalse($this->_interval1->encompasses($this->_interval3));
        $this->assertFalse($this->_interval1->encompasses($this->_interval4));

        $this->assertFalse($this->_interval2->encompasses($this->_interval1));
        $this->assertTrue($this->_interval2->encompasses($this->_interval2));
        $this->assertFalse($this->_interval2->encompasses($this->_interval3));
        $this->assertFalse($this->_interval2->encompasses($this->_interval4));

        $this->assertFalse($this->_interval3->encompasses($this->_interval1));
        $this->assertFalse($this->_interval3->encompasses($this->_interval2));
        $this->assertTrue($this->_interval3->encompasses($this->_interval3));
        $this->assertFalse($this->_interval3->encompasses($this->_interval4));

        $this->assertFalse($this->_interval4->encompasses($this->_interval1));
        $this->assertTrue($this->_interval4->encompasses($this->_interval2));
        $this->assertTrue($this->_interval4->encompasses($this->_interval3));
        $this->assertTrue($this->_interval4->encompasses($this->_interval4));
    }

    public function testIntersects()
    {
        /*
                    A   B   C   D   E
        Interval 1: *****
        Interval 2:         *****
        Interval 3:     *****
        Interval 4:     *************
        */

        $this->assertTrue($this->_interval1->intersects($this->_interval1));
        $this->assertFalse($this->_interval1->intersects($this->_interval2));
        $this->assertTrue($this->_interval1->intersects($this->_interval3));
        $this->assertTrue($this->_interval1->intersects($this->_interval4));

        $this->assertFalse($this->_interval2->intersects($this->_interval1));
        $this->assertTrue($this->_interval2->intersects($this->_interval2));
        $this->assertTrue($this->_interval2->intersects($this->_interval3));
        $this->assertTrue($this->_interval2->intersects($this->_interval4));

        $this->assertTrue($this->_interval3->intersects($this->_interval1));
        $this->assertTrue($this->_interval3->intersects($this->_interval2));
        $this->assertTrue($this->_interval3->intersects($this->_interval3));
        $this->assertTrue($this->_interval3->intersects($this->_interval4));

        $this->assertTrue($this->_interval4->intersects($this->_interval1));
        $this->assertTrue($this->_interval4->intersects($this->_interval2));
        $this->assertTrue($this->_interval4->intersects($this->_interval3));
        $this->assertTrue($this->_interval4->intersects($this->_interval4));
    }
}
