<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit_Framework_TestCase;

class IntervalTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->pointA = new Date(2012, 1, 1);
        $this->pointB = new Date(2012, 1, 5);
        $this->interval = new Interval($this->pointA, $this->pointB);
    }

    public function testConstructFailure()
    {
        $this->setExpectedException('InvalidArgumentException', 'Start point must not be greater than end point.');
        new Interval($this->pointB, $this->pointA);
    }

    public function testConstructEmpty()
    {
        $interval = new Interval($this->pointA, $this->pointA);
        $this->assertTrue($interval->isEmpty());
    }

    public function testStart()
    {
        $this->assertSame($this->pointA, $this->interval->start());
    }

    public function testEnd()
    {
        $this->assertSame($this->pointB, $this->interval->end());
    }
}
