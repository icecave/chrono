<?php
namespace Icecave\Chrono;

use Eloquent\Liberator\Liberator;
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
        $this->assertSame('2013-02-01T10:00:00+10:00', $result->isoString());
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
        $this->assertSame('2013-01-31T14:00:00+00:00', $result->isoString());
    }

    public function testTimeZone()
    {
        $this->assertTrue($this->_date->timeZone()->isUtc());

        $timeZone = new TimeZone(36000, true);
        $date = new Date(2013, 2, 1, $timeZone);
        $this->assertSame($timeZone, $date->timeZone());
    }

    public function testAt()
    {
        $time = new Time(10, 20, 30);
        $result = $this->_date->at($time);
        $expected = new DateTime(2013, 2, 1, 10, 20, 30);

        $this->assertEquals($expected, $result);
    }

    public function testAtWithTimeZoneCoversion()
    {
        $time = new Time(10, 20, 30, new TimeZone(36000));
        $result = $this->_date->at($time);
        $expected = new DateTime(2013, 2, 1, 0, 20, 30);

        $this->assertEquals($expected, $result);
    }

    public function testCompareSelf()
    {
        $this->assertSame(0, $this->_date->compare($this->_date));
    }

    public function testCompareClone()
    {
        $date = clone $this->_date;
        $this->assertSame(0, $this->_date->compare($date));
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

    public function testCompareTimeZone()
    {
        $date = new Date(2013, 2, 1, new TimeZone(36000));
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

    public function testFormat()
    {
        $formatter = Phake::mock(__NAMESPACE__ . '\Format\FormatterInterface');
        Liberator::liberateClass(__NAMESPACE__ . '\Format\DefaultFormatter')->instance = $formatter;

        Phake::when($formatter)
            ->formatDate(Phake::anyParameters())
            ->thenReturn('<1st>')
            ->thenReturn('<2nd>');

        $result = $this->_date->format('Y-m-d');
        $this->assertSame('<1st>', $result);

        $result = $this->_date->format('Y-m-d', $formatter);
        $this->assertSame('<2nd>', $result);

        Phake::verify($formatter, Phake::times(2))->formatDate($this->_date, 'Y-m-d');
    }

    public function testIsoString()
    {
        $this->assertEquals('2013-02-01', $this->_date->isoString());
        $this->assertEquals('2013-02-01', $this->_date->__toString());
    }
}
