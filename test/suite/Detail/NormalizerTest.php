<?php

namespace Icecave\Chrono\Detail;

use PHPUnit\Framework\TestCase;

class NormalizerTest extends TestCase
{
    /**
     * @dataProvider normalizeTimeData
     */
    public function testNormalizeTime($hours, $minutes, $seconds, $expected, $expectedDays)
    {
        $days = 0;
        Normalizer::normalizeTime($hours, $minutes, $seconds, $days);

        $this->assertSame($expected, sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds));
        $this->assertSame($expectedDays, $days);
    }

    public function testNormalizeTimeIncreasesDay()
    {
        $days    = 5;
        $hours   = 25;
        $minutes = 0;
        $seconds = 0;

        Normalizer::normalizeTime($hours, $minutes, $seconds, $days);

        $this->assertSame(1, $hours);
        $this->assertSame(0, $minutes);
        $this->assertSame(0, $seconds);
        $this->assertSame(6, $days);
    }

    public function testNormalizeTimeWithoutDayParameter()
    {
        $hours   = 25;
        $minutes = 0;
        $seconds = 0;

        Normalizer::normalizeTime($hours, $minutes, $seconds);

        $this->assertSame(1, $hours);
        $this->assertSame(0, $minutes);
        $this->assertSame(0, $seconds);
    }

    public function normalizeTimeData()
    {
        return [
            'valid time'                 => [10, 25, 13,    '10:25:13',     0],
            'min'                        => [0,  0,  0,    '00:00:00',     0],
            'max'                        => [23, 59, 59,    '23:59:59',     0],

            'seconds overflow'           => [10, 25, 70,    '10:26:10',     0],
            'minutes overflow'           => [10, 70, 13,    '11:10:13',     0],
            'hours overflow'             => [25, 25, 13,    '01:25:13',     1],
            'all overflow'               => [25, 70, 70,    '02:11:10',     1],

            'seconds overflow multiple'  => [10, 25, 130,   '10:27:10',     0],
            'minutes overflow multiple'  => [10, 130, 13,   '12:10:13',     0],
            'hours overflow multiple'    => [49, 25, 13,    '01:25:13',     2],

            'seconds underflow'          => [10, 25, -10,   '10:24:50',     0],
            'minutes underflow'          => [10, -10, 13,   '09:50:13',     0],
            'hours underflow'            => [-10, 25, 13,   '14:25:13',     -1],

            'seconds underflow multiple' => [10, 25, -70,   '10:23:50',     0],
            'minutes underflow multiple' => [10, -70, 13,   '08:50:13',     0],
            'hours underflow multiple'   => [-34, 25, 13,   '14:25:13',     -2],

            'seconds underflow exact'    => [10, 25, -60,   '10:24:00',     0],
            'minutes underflow exact'    => [10, -60, 13,   '09:00:13',     0],
            'hours underflow exact'      => [-24, 25, 13,   '00:25:13',     -1],

            'seconds overflow hour'      => [0, 0, 3600,    '01:00:00',     0],
            'seconds overflow day'       => [0, 0, 86400,   '00:00:00',     1],
        ];
    }

    /**
     * @dataProvider normalizeDateData
     */
    public function testNormalizeDate($year, $month, $day, $expected)
    {
        Normalizer::normalizeDate($year, $month, $day);
        $this->assertSame($expected, sprintf('%04d-%02d-%02d', $year, $month, $day));
    }

    public function normalizeDateData()
    {
        return [
            'valid date'                => [2012,  6, 14,      '2012-06-14'],
            'min'                       => [0,  1,  1,      '0000-01-01'], // Note, behavior here deviates from [gm]mktime.
            'max'                       => [9999, 12, 31,      '9999-12-31'],

            'day overflow'              => [2012,  6, 31,      '2012-07-01'],
            'month overflow'            => [2012, 13,  1,      '2013-01-01'],

            'day overflow multiple'     => [2012,  6, 62,      '2012-08-01'],
            'month overflow multiple'   => [2012, 25,  1,      '2014-01-01'],

            'zeroes'                    => [2012,  0,  0,      '2011-11-30'],
        ];
    }
}
