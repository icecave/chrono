<?php
namespace Icecave\Chrono;

use Phake;
use PHPUnit_Framework_TestCase;

class DateTimeTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_dateTime = new DateTime(2013, 2, 1, 10, 20, 30);
    }

    public function testNormalization()
    {
        $time = new DateTime(2013, 1, 32, 10, 20, 70);
        $this->assertSame('2013-02-01 10:21:10+00:00', $time->isoString());
    }

    public function testYear()
    {
        $this->assertSame(2013, $this->_dateTime->year());
    }

    public function testMonth()
    {
        $this->assertSame(2, $this->_dateTime->month());
    }

    public function testDay()
    {
        $this->assertSame(1, $this->_dateTime->day());
    }

    public function testHours()
    {
        $this->assertSame(10, $this->_dateTime->hours());
    }

    public function testMinutes()
    {
        $this->assertSame(20, $this->_dateTime->minutes());
    }

    public function testSeconds()
    {
        $this->assertSame(30, $this->_dateTime->seconds());
    }

    public function testToTimeZone()
    {
        $timeZone = new TimeZone(36000);
        $result = $this->_dateTime->toTimeZone($timeZone);

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $result);
        $this->assertSame('2013-02-01 20:20:30+10:00', $result->isoString());
    }

    public function testToTimeZoneSame()
    {
        $result = $this->_dateTime->toTimeZone(new TimeZone);
        $this->assertSame($this->_dateTime, $result);
    }

    public function testToUtc()
    {
        $timeZone = new TimeZone(36000);
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, $timeZone);
        $result = $dateTime->toUtc();

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $result);
        $this->assertSame('2013-02-01 00:20:30+00:00', $result->isoString());
    }

    public function testTimeZone()
    {
        $this->assertTrue($this->_dateTime->timeZone()->isUtc());

        $timeZone = new TimeZone(36000, true);
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, $timeZone);
        $this->assertSame($timeZone, $dateTime->timeZone());
    }

    public function testDate()
    {
        $timeZone = new TimeZone(36000);
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, $timeZone);
        $expected = new Date(2013, 2, 1, $timeZone);
        $result   = $dateTime->date();

        $this->assertEquals($expected, $result);
    }

    public function testTime()
    {
        $timeZone = new TimeZone(36000);
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, $timeZone);
        $expected = new Time(10, 20, 30, $timeZone);
        $result   = $dateTime->time();

        $this->assertEquals($expected, $result);
    }

    public function testCompareSelf()
    {
        $this->assertSame(0, $this->_dateTime->compare($this->_dateTime));
    }

    public function testCompareClone()
    {
        $dateTime = clone $this->_dateTime;
        $this->assertSame(0, $this->_dateTime->compare($dateTime));
    }

    public function testCompareDateTime()
    {
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 31);
        $this->assertLessThan(0, $this->_dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->_dateTime));

        $dateTime = new DateTime(2013, 2, 1, 10, 21, 30);
        $this->assertLessThan(0, $this->_dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->_dateTime));

        $dateTime = new DateTime(2013, 2, 1, 11, 20, 30);
        $this->assertLessThan(0, $this->_dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->_dateTime));

        $dateTime = new DateTime(2013, 2, 2, 10, 20, 30);
        $this->assertLessThan(0, $this->_dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->_dateTime));

        $dateTime = new DateTime(2013, 3, 1, 10, 20, 30);
        $this->assertLessThan(0, $this->_dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->_dateTime));

        $dateTime = new DateTime(2014, 2, 1, 10, 20, 30);
        $this->assertLessThan(0, $this->_dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->_dateTime));
    }

    public function testCompareTimeZone()
    {
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, new TimeZone(36000));
        $this->assertLessThan(0, $this->_dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->_dateTime));
    }

    public function testCompareOther()
    {
        $timePoint = Phake::mock(__NAMESPACE__ . '\TimePointInterface');
        Phake::when($timePoint)
            ->unixTime()
            ->thenReturn(1359714031);

        $this->assertLessThan(0, $this->_dateTime->compare($timePoint));
    }

    public function testUnixTime()
    {
        $this->assertSame(1359714030, $this->_dateTime->unixTime());
    }

    public function testUnixTimeWithTimeZone()
    {
        $timeZone = new TimeZone(36000, true);
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, $timeZone);

        $this->assertSame(1359678030, $dateTime->unixTime());
    }

    public function testIsoString()
    {
        $this->assertEquals('2013-02-01 10:20:30+00:00', $this->_dateTime->isoString());
        $this->assertEquals('2013-02-01 10:20:30+00:00', $this->_dateTime->__toString());
    }
}
