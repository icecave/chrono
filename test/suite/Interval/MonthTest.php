<?php

namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit\Framework\TestCase;

/**
 * @covers Icecave\Chrono\Interval\Month
 * @covers Icecave\Chrono\Detail\Iso8601
 */
class MonthTest extends TestCase
{
    public function setUp(): void
    {
        $this->year  = new Year(2012);
        $this->month = new Month($this->year, 2);
    }

    public function testCreateFromTimePoint()
    {
        $month = Month::fromTimePoint(new Date(2012, 12, 30));
        $this->assertInstanceOf(__NAMESPACE__ . '\Month', $month);
        $this->assertSame(2012, $month->year()->ordinal());
        $this->assertSame(12, $month->ordinal());
    }

    public function testYear()
    {
        $this->assertSame($this->year, $this->month->year());
    }

    public function testOrdinal()
    {
        $this->assertSame(2, $this->month->ordinal());
    }

    public function testStart()
    {
        $this->assertEquals(new Date(2012, 2, 1), $this->month->start());
    }

    public function testEnd()
    {
        $this->assertEquals(new Date(2012, 3, 1), $this->month->end());
    }

    public function testNumberOfDays()
    {
        $this->assertEquals(29, $this->month->numberOfDays());
    }

    public function testIsoString()
    {
        $this->assertEquals('2012-02', $this->month->isoString());
        $this->assertEquals('2012-02', $this->month->__toString());
    }

    /**
     * @dataProvider validIsoStrings
     */
    public function testFromIsoString($isoString, $expected)
    {
        $result = Month::fromIsoString($isoString);
        $this->assertSame($expected, $result->isoString());
    }

    public function validIsoStrings()
    {
        return [
            'With zero prefix month'        => ['2012-02',     '2012-02'],
            'With zero prefix year'         => ['0012-02',     '0012-02'],
        ];
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoMonth($isoString, $expected)
    {
        $this->expectException('InvalidArgumentException', $expected);
        Month::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return [
            'Empty'                                     => ['',            'Invalid ISO year month: ""'],
            'Not enough digits'                         => ['1',           'Invalid ISO year month: "1"'],
            'Not enough digits'                         => ['12',          'Invalid ISO year month: "12"'],
            'Not enough digits'                         => ['123',         'Invalid ISO year month: "123"'],
            'Not enough digits'                         => ['1234',        'Invalid ISO year month: "1234"'],
            'Not enough digits'                         => ['12345',       'Invalid ISO year month: "12345"'],
            'Missing seperator'                         => ['123456',      'Invalid ISO year month: "123456"'],
            'Invalid seperator'                         => ['1234/56',     'Invalid ISO year month: "1234/56"'],
            'Invalid format, month-year'                => ['12-3456',     'Invalid ISO year month: "12-3456"'],
            'Invalid format, seperator, month-year'     => ['12/3456',     'Invalid ISO year month: "12/3456"'],
            'Invalid format, 2 digit year'              => ['12-34',       'Invalid ISO year month: "12-34"'],
        ];
    }
}
