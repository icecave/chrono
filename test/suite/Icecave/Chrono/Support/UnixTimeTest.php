<?php
namespace Icecave\Chrono\Support;

use PHPUnit_Framework_TestCase;

class UnixTimeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider makeTimestampData
     */
    public function testMakeTimestamp($year, $month, $day, $hours, $minutes, $seconds)
    {
        $timestamp = UnixTime::makeTimestamp($year, $month, $day, $hours, $minutes, $seconds);

        $this->assertSame(gmmktime($hours, $minutes, $seconds, $month, $day, $year), $timestamp);
    }

    public function makeTimestampData()
    {
        return array(
            'Y__ ___' => array(2012, 1, 1, 0, 0, 0),
            'YM_ ___' => array(2012, 2, 1, 0, 0, 0),
            'YMD ___' => array(2012, 2, 2, 0, 0, 0),

            'YMD H__' => array(2012, 2, 2, 10, 0, 0),
            'YMD HM_' => array(2012, 2, 2, 10, 20, 0),
            'YMD HMS' => array(2012, 2, 2, 10, 20, 30),

            '< EPOCH' => array(1969, 6, 14, 2, 4, 1),
            'LEAP YR' => array(2012, 3, 2, 10, 20, 30),
        );
    }
}
