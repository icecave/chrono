<?php
namespace Icecave\Chrono\Detail;

use PHPUnit_Framework_TestCase;

class NormalizerTest extends PHPUnit_Framework_TestCase
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
        return array(
            'valid time'                 => array(10, 25, 13,    '10:25:13',     0),
            'min'                        => array( 0,  0,  0,    '00:00:00',     0),
            'max'                        => array(23, 59, 59,    '23:59:59',     0),

            'seconds overflow'           => array(10, 25, 70,    '10:26:10',     0),
            'minutes overflow'           => array(10, 70, 13,    '11:10:13',     0),
            'hours overflow'             => array(25, 25, 13,    '01:25:13',     1),
            'all overflow'               => array(25, 70, 70,    '02:11:10',     1),

            'seconds overflow multiple'  => array(10, 25, 130,   '10:27:10',     0),
            'minutes overflow multiple'  => array(10, 130, 13,   '12:10:13',     0),
            'hours overflow multiple'    => array(49, 25, 13,    '01:25:13',     2),

            'seconds underflow'          => array(10, 25, -10,   '10:24:50',     0),
            'minutes underflow'          => array(10, -10, 13,   '09:50:13',     0),
            'hours underflow'            => array(-10, 25, 13,   '14:25:13',     -1),

            'seconds underflow multiple' => array(10, 25, -70,   '10:23:50',     0),
            'minutes underflow multiple' => array(10, -70, 13,   '08:50:13',     0),
            'hours underflow multiple'   => array(-34, 25, 13,   '14:25:13',     -2),

            'seconds underflow exact'    => array(10, 25, -60,   '10:24:00',     0),
            'minutes underflow exact'    => array(10, -60, 13,   '09:00:13',     0),
            'hours underflow exact'      => array(-24, 25, 13,   '00:25:13',     -1),

            'seconds overflow hour'      => array(0, 0, 3600,    '01:00:00',     0),
            'seconds overflow day'       => array(0, 0, 86400,   '00:00:00',     1),
        );
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
        return array(
            'valid date'                => array(2012,  6, 14,      '2012-06-14'),
            'min'                       => array(   0,  1,  1,      '0000-01-01'), // Note, behavior here deviates from [gm]mktime.
            'max'                       => array(9999, 12, 31,      '9999-12-31'),

            'day overflow'              => array(2012,  6, 31,      '2012-07-01'),
            'month overflow'            => array(2012, 13,  1,      '2013-01-01'),

            'day overflow multiple'     => array(2012,  6, 62,      '2012-08-01'),
            'month overflow multiple'   => array(2012, 25,  1,      '2014-01-01'),

            'zeroes'                    => array(2012,  0,  0,      '2011-11-30'),
        );
    }
}
