<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit_Framework_TestCase;

class MonthTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_year = new Year(2012);
        $this->_month = new Month($this->_year, 2);
    }

    public function testYear()
    {
        $this->assertSame($this->_year, $this->_month->year());
    }

    public function testOrdinal()
    {
        $this->assertSame(2, $this->_month->ordinal());
    }

    public function testStart()
    {
        $this->assertEquals(new Date(2012, 2, 1), $this->_month->start());
    }

    public function testEnd()
    {
        $this->assertEquals(new Date(2012, 2, 29), $this->_month->end());
    }

    public function testNumberOfDays()
    {
        $this->assertEquals(29, $this->_month->numberOfDays());
    }

    public function testIsoString()
    {
        $this->assertEquals('2012-02', $this->_month->isoString());
        $this->assertEquals('2012-02', $this->_month->__toString());
    }
}
