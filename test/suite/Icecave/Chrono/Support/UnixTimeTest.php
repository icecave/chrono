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
            array(2012, 6, 14, 2, 4, 1),
            array(2011, 6, 14, 2, 4, 1),
            array(1969, 6, 14, 2, 4, 1)
        );
    }
}
