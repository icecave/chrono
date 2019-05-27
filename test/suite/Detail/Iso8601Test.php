<?php

namespace Icecave\Chrono\Detail;

use PHPUnit\Framework\TestCase;

class Iso8601Test extends TestCase
{
    public function parseTimeData()
    {
        return array(
            'No microseconds' => array(
                '10:20:30-11:22',
                array(
                    'hour'        => 10,
                    'minute'      => 20,
                    'second'      => 30,
                    'microsecond' => 0,
                    'offset'      => -((11 * 60 * 60) + (22 * 60)),
                ),
            ),
            'Microseconds' => array(
                '10:20:30.123456-11:22',
                array(
                    'hour'        => 10,
                    'minute'      => 20,
                    'second'      => 30,
                    'microsecond' => 123456,
                    'offset'      => -((11 * 60 * 60) + (22 * 60)),
                ),
            ),
            'Microseconds with excess precision' => array(
                '10:20:30.1234567890-11:22',
                array(
                    'hour'        => 10,
                    'minute'      => 20,
                    'second'      => 30,
                    'microsecond' => 123456,
                    'offset'      => -((11 * 60 * 60) + (22 * 60)),
                ),
            ),
            'Microseconds with insufficient precision' => array(
                '10:20:30.1-11:22',
                array(
                    'hour'        => 10,
                    'minute'      => 20,
                    'second'      => 30,
                    'microsecond' => 100000,
                    'offset'      => -((11 * 60 * 60) + (22 * 60)),
                ),
            ),
        );
    }

    /**
     * @dataProvider parseTimeData
     */
    public function testParseTime($isoString, $expected)
    {
        $this->assertSame($expected, Iso8601::parseTime($isoString));
    }

    public function parseDateTimeData()
    {
        return array(
            'No microseconds' => array(
                '2013-02-01T10:20:30-11:22',
                array(
                    'year'        => 2013,
                    'month'       => 2,
                    'day'         => 1,
                    'hour'        => 10,
                    'minute'      => 20,
                    'second'      => 30,
                    'microsecond' => 0,
                    'offset'      => -((11 * 60 * 60) + (22 * 60)),
                ),
            ),
            'Microseconds' => array(
                '2013-02-01T10:20:30.123456-11:22',
                array(
                    'year'        => 2013,
                    'month'       => 2,
                    'day'         => 1,
                    'hour'        => 10,
                    'minute'      => 20,
                    'second'      => 30,
                    'microsecond' => 123456,
                    'offset'      => -((11 * 60 * 60) + (22 * 60)),
                ),
            ),
            'Microseconds with excess precision' => array(
                '2013-02-01T10:20:30.1234567890-11:22',
                array(
                    'year'        => 2013,
                    'month'       => 2,
                    'day'         => 1,
                    'hour'        => 10,
                    'minute'      => 20,
                    'second'      => 30,
                    'microsecond' => 123456,
                    'offset'      => -((11 * 60 * 60) + (22 * 60)),
                ),
            ),
            'Microseconds with insufficient precision' => array(
                '2013-02-01T10:20:30.1-11:22',
                array(
                    'year'        => 2013,
                    'month'       => 2,
                    'day'         => 1,
                    'hour'        => 10,
                    'minute'      => 20,
                    'second'      => 30,
                    'microsecond' => 100000,
                    'offset'      => -((11 * 60 * 60) + (22 * 60)),
                ),
            ),
        );
    }

    /**
     * @dataProvider parseDateTimeData
     */
    public function testParseDateTime($isoString, $expected)
    {
        $this->assertSame($expected, Iso8601::parseDateTime($isoString));
    }
}
