<?php

namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit\Framework\TestCase;

/**
 * @covers Icecave\Chrono\Interval\Year
 * @covers Icecave\Chrono\Detail\Iso8601
 */
class YearTest extends TestCase
{
    public function setUp(): void
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

    /**
     * @dataProvider validIsoStrings
     */
    public function testFromIsoString($isoString, $expected)
    {
        $result = Year::fromIsoString($isoString);
        $this->assertSame($expected, $result->isoString());
    }

    public function validIsoStrings()
    {
        return [
            'Year'              => ['2012',    '2012'],
            'Zero prefix year'  => ['0012',    '0012'],
        ];
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoYear($isoString, $expected)
    {
        $this->expectException('InvalidArgumentException', $expected);
        Year::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return [
            'Empty'                 => ['',        'Invalid ISO year: ""'],
            'Not enough digits'     => ['1',       'Invalid ISO year: "1"'],
            'Not enough digits'     => ['12',      'Invalid ISO year: "12"'],
            'Not enough digits'     => ['123',     'Invalid ISO year: "123"'],
        ];
    }
}
