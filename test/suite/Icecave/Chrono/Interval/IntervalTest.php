<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit_Framework_TestCase;

class IntervalTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_pointA = new Date(2012, 1, 1);
        $this->_pointB = new Date(2012, 1, 5);
        $this->_interval = new Interval($this->_pointA, $this->_pointB);
    }

    public function testConstructFailure()
    {
        $this->setExpectedException('InvalidArgumentException', 'Start point must not be greater than end point.');
        new Interval($this->_pointB, $this->_pointA);
    }

    public function testConstructEmpty()
    {
        $interval = new Interval($this->_pointA, $this->_pointA);
        $this->assertTrue($interval->isEmpty());
    }

    public function testStart()
    {
        $this->assertSame($this->_pointA, $this->_interval->start());
    }

    public function testEnd()
    {
        $this->assertSame($this->_pointB, $this->_interval->end());
    }
}
