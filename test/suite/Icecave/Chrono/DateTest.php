<?php
namespace Icecave\Chrono;

use Phake;
use PHPUnit_Framework_TestCase;

class DateTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_date = new Date(2013, 2, 1);
    }

    public function testNormalization()
    {
        $date = new Date(2013, 1, 32);
        $this->assertSame('2013-02-01', $date->isoString());
    }

    public function testYear()
    {
        $this->assertSame(2013, $this->_date->year());
    }

    public function testMonth()
    {
        $this->assertSame(2, $this->_date->month());
    }

    public function testDay()
    {
        $this->assertSame(1, $this->_date->day());
    }

    public function testToTimeZone()
    {
        $timeZone = new TimeZone(36000);
        $result = $this->_date->toTimeZone($timeZone);

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $result);
        $this->assertSame('2013-02-01 10:00:00+10:00', $result->isoString());
    }

    public function testToTimeZoneSame()
    {
        $result = $this->_date->toTimeZone(new TimeZone);
        $this->assertSame($this->_date, $result);
    }

    public function testToUtc()
    {
        $timeZone = new TimeZone(36000);
        $date = new Date(2013, 2, 1, $timeZone);
        $result = $date->toUtc();

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $result);
        $this->assertSame('2013-01-31 14:00:00+00:00', $result->isoString());
    }

    public function testTimeZone()
    {
        $this->assertTrue($this->_date->timeZone()->isUtc());

        $timeZone = new TimeZone(36000, true);
        $date = new Date(2013, 2, 1, $timeZone);
        $this->assertSame($timeZone, $date->timeZone());
    }

    public function testCompareSelf()
    {
        $this->assertSame(0, $this->_date->compare($this->_date));
    }

    public function testCompareDate()
    {
        $date = new Date(2013, 2, 2);
        $this->assertLessThan(0, $this->_date->compare($date));
        $this->assertGreaterThan(0, $date->compare($this->_date));

        $date = new Date(2013, 3, 1);
        $this->assertLessThan(0, $this->_date->compare($date));
        $this->assertGreaterThan(0, $date->compare($this->_date));

        $date = new Date(2014, 2, 1);
        $this->assertLessThan(0, $this->_date->compare($date));
        $this->assertGreaterThan(0, $date->compare($this->_date));
    }

    public function testCompareOther()
    {
        $timePoint = Phake::mock(__NAMESPACE__ . '\TimePointInterface');
        Phake::when($timePoint)
            ->unixTime()
            ->thenReturn(1359676801);

        $this->assertLessThan(0, $this->_date->compare($timePoint));
    }

    public function testUnixTime()
    {
        $this->assertSame(1359676800, $this->_date->unixTime());
    }

    public function testUnixTimeWithTimeZone()
    {
        $timeZone = new TimeZone(36000, true);
        $date = new Date(2013, 2, 1, $timeZone);

        $this->assertSame(1359640800, $date->unixTime());
    }

    public function testIsoString()
    {
        $this->assertEquals('2013-02-01', $this->_date->isoString());
        $this->assertEquals('2013-02-01', $this->_date->__toString());
    }
}
