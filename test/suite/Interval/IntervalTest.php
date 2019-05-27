<?php

namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use PHPUnit\Framework\TestCase;

/**
 * @covers Icecave\Chrono\Interval\Interval
 * @covers Icecave\Chrono\Detail\Iso8601
 */
class IntervalTest extends TestCase
{
    public function setUp()
    {
        $this->pointA   = new Date(2012, 1, 1);
        $this->pointB   = new Date(2012, 1, 5);
        $this->interval = new Interval($this->pointA, $this->pointB);
    }

    public function testConstructFailure()
    {
        $this->expectException('InvalidArgumentException', 'Start point must not be greater than end point.');
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

    public function testIsoString()
    {
        $this->assertSame('2012-01-01T00:00:00+00:00/2012-01-05T00:00:00+00:00', $this->interval->isoString());
        $this->assertSame('2012-01-01T00:00:00+00:00/2012-01-05T00:00:00+00:00', $this->interval->__toString());
    }

    public function testIsoStringWithPeriod()
    {
        $this->assertSame('2012-01-01T00:00:00+00:00/P4D', $this->interval->isoStringWithPeriod());
    }

    /**
     * @dataProvider validIsoStrings
     */
    public function testFromIsoString($isoString, $expected)
    {
        $result = Interval::fromIsoString($isoString);
        $this->assertSame($expected, $result->isoString());
    }

    public function validIsoStrings()
    {
        return array(
            // Duration/DateTime Format
            'Duration and DateTime'                 => array('P1DT2H/2012-10-21T13:22:33',                          '2012-10-20T11:22:33+00:00/2012-10-21T13:22:33+00:00'),
            'Duration and DateTime with timezone'   => array('P1DT2H/2012-10-21T13:22:33+12:34',                    '2012-10-20T11:22:33+12:34/2012-10-21T13:22:33+12:34'),

            // DateTime/Duration Format
            'DateTime and Duration'                 => array('2012-10-20T11:22:33/P1DT2H',                          '2012-10-20T11:22:33+00:00/2012-10-21T13:22:33+00:00'),
            'DateTime with timezone and Duration'   => array('2012-10-20T11:22:33+12:34/P1DT2H',                    '2012-10-20T11:22:33+12:34/2012-10-21T13:22:33+12:34'),

            // DateTime/DateTime Format
            'DateTime and DateTime'                 => array('2011-11-11T11:11:11/2022-12-22T22:22:22',             '2011-11-11T11:11:11+00:00/2022-12-22T22:22:22+00:00'),
            'DateTime and DateTime with timezones'  => array('2011-11-11T11:11:11+11:11/2022-12-22T22:22:22+22:22', '2011-11-11T11:11:11+11:11/2022-12-22T22:22:22+22:22'),
        );
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoString($isoString, $expected)
    {
        $this->expectException('InvalidArgumentException', $expected);
        $result = Interval::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return array(
            'Empty'                                     => array('',                                    'Invalid ISO interval: "".'),
            'Empty /'                                   => array('/',                                   'Invalid ISO interval: "/".'),

            // Duration Format - Not supported
            'Duration Format only is not supported'     => array('P',                                   'Invalid ISO interval: "P".'),
            'Duration Format only is not supported'     => array('P12DT10H',                            'Invalid ISO interval: "P12DT10H".'),

            // DateTime/Duration Format
            'Duration and DateTime empty'               => array('P/',                                  'Invalid ISO duration: "P".'),
            'Duration empty'                            => array('P/2012-10-20T11:22:33+00:00',         'Invalid ISO duration: "P".'),

            // DateTime/Duration Format
            'DateTime and Duration empty'               => array('/P',                                  'Invalid ISO date time: "".'),
            'Duration empty'                            => array('2012-10-20T11:22:33+00:00/P',         'Invalid ISO duration: "P".'),
        );
    }
}
