<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit_Framework_TestCase;

class YearTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_year = new Year(2012);
    }

    public function testOrdinal()
    {
        $this->assertSame(2012, $this->_year->ordinal());
    }

    public function testStart()
    {
        $this->assertEquals(new Date(2012, 1, 1), $this->_year->start());
    }

    public function testEnd()
    {
        $this->assertEquals(new Date(2012, 12, 31), $this->_year->end());
    }

    public function testNumberOfDays()
    {
        $year = new Year(2011);
        $this->assertEquals(365, $year->numberOfDays());
    }

    public function testNumberOfDaysLeapYear()
    {
        $this->assertEquals(366, $this->_year->numberOfDays());
    }

    public function testIsoString()
    {
        $this->assertEquals('2012', $this->_year->isoString());
        $this->assertEquals('2012', $this->_year->__toString());
    }
}
