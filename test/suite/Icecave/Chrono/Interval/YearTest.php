<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit_Framework_TestCase;

class YearTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->year = new Year(2012);
    }

    public function testCreateFromTimePoint()
    {
        $year = Year::fromTimePoint(new Date(2012, 12, 30));
        $this->assertInstanceOf(__NAMESPACE__ . '\Year', $year);
        $this->assertSame(2012, $year->ordinal());
    }

    public function testOrdinal()
    {
        $this->assertSame(2012, $this->year->ordinal());
    }

    public function testStart()
    {
        $this->assertEquals(new Date(2012, 1, 1), $this->year->start());
    }

    public function testEnd()
    {
        $this->assertEquals(new Date(2013, 1, 1), $this->year->end());
    }

    public function testNumberOfDays()
    {
        $year = new Year(2011);
        $this->assertEquals(365, $year->numberOfDays());
    }

    public function testNumberOfDaysLeapYear()
    {
        $this->assertEquals(366, $this->year->numberOfDays());
    }

    public function testIsLeapYear()
    {
        $year = new Year(2011);
        $this->assertFalse($year->isLeapYear());

        $this->assertTrue($this->year->isLeapYear());
    }

    public function testIsoString()
    {
        $this->assertEquals('2012', $this->year->isoString());
        $this->assertEquals('2012', $this->year->__toString());
    }
}
