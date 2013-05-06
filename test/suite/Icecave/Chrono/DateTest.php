<?php
namespace Icecave\Chrono;

use Eloquent\Liberator\Liberator;
use Phake;
use PHPUnit_Framework_TestCase;

class DateTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->date = new Date(2013, 2, 1);
    }

    public function testNormalization()
    {
        $date = new Date(2013, 1, 32);
        $this->assertSame('2013-02-01', $date->isoString());
    }

    public function testYear()
    {
        $this->assertSame(2013, $this->date->year());
    }

    public function testMonth()
    {
        $this->assertSame(2, $this->date->month());
    }

    public function testDay()
    {
        $this->assertSame(1, $this->date->day());
    }

    public function testToTimeZone()
    {
        $timeZone = new TimeZone(36000);
        $result = $this->date->toTimeZone($timeZone);

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $result);
        $this->assertSame('2013-02-01T10:00:00+10:00', $result->isoString());
    }

    public function testToTimeZoneSame()
    {
        $result = $this->date->toTimeZone(new TimeZone);
        $this->assertSame($this->date, $result);
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
        $this->assertTrue($this->date->timeZone()->isUtc());

        $timeZone = new TimeZone(36000, true);
        $date = new Date(2013, 2, 1, $timeZone);
        $this->assertSame($timeZone, $date->timeZone());
    }

    public function testAt()
    {
        $time = new TimeOfDay(10, 20, 30);
        $result = $this->date->at($time);
        $expected = new DateTime(2013, 2, 1, 10, 20, 30);

        $this->assertEquals($expected, $result);
    }

    public function testAtWithTimeZoneCoversion()
    {
        $time = new TimeOfDay(10, 20, 30, new TimeZone(36000));
        $result = $this->date->at($time);
        $expected = new DateTime(2013, 2, 1, 0, 20, 30);

        $this->assertEquals($expected, $result);
    }

    public function testCompareSelf()
    {
        $this->assertSame(0, $this->date->compare($this->date));
    }

    public function testCompareClone()
    {
        $date = clone $this->date;
        $this->assertSame(0, $this->date->compare($date));
    }

    public function testCompareDate()
    {
        $date = new Date(2013, 2, 2);
        $this->assertLessThan(0, $this->date->compare($date));
        $this->assertGreaterThan(0, $date->compare($this->date));

        $date = new Date(2013, 3, 1);
        $this->assertLessThan(0, $this->date->compare($date));
        $this->assertGreaterThan(0, $date->compare($this->date));

        $date = new Date(2014, 2, 1);
        $this->assertLessThan(0, $this->date->compare($date));
        $this->assertGreaterThan(0, $date->compare($this->date));
    }

    public function testCompareTimeZone()
    {
        $date = new Date(2013, 2, 1, new TimeZone(36000));
        $this->assertLessThan(0, $this->date->compare($date));
        $this->assertGreaterThan(0, $date->compare($this->date));
    }

    public function testCompareOther()
    {
        $timePoint = Phake::mock(__NAMESPACE__ . '\TimePointInterface');
        Phake::when($timePoint)
            ->unixTime()
            ->thenReturn(1359676801);

        $this->assertLessThan(0, $this->date->compare($timePoint));
    }

    public function testUnixTime()
    {
        $this->assertSame(1359676800, $this->date->unixTime());
    }

    public function testFromUnixTime()
    {
        $date = Date::fromUnixTime(1359714030);
        $this->assertSame('2013-02-01', $date->isoString());
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

        $result = $this->date->format('Y-m-d');
        $this->assertSame('<1st>', $result);

        $result = $this->date->format('Y-m-d', $formatter);
        $this->assertSame('<2nd>', $result);

        Phake::verify($formatter, Phake::times(2))->formatDate($this->date, 'Y-m-d');
    }

    public function testIsoString()
    {
        $this->assertEquals('2013-02-01', $this->date->isoString());
        $this->assertEquals('2013-02-01', $this->date->__toString());
    }

    /**
     * @dataProvider validIsoStrings
     */
    public function testFromIsoString($isoString, $expected)
    {
        $result = Date::fromIsoString($isoString);
        $this->assertSame($expected, $result->isoString());
    }

    public function validIsoStrings()
    {
        return array(
            'Basic'    => array('20130201',   '2013-02-01'),
            'Extended' => array('2013-02-01', '2013-02-01')
        );
    }

    /**
     * @dataProvider validIsoStringsWithTimeZone
     */
    public function testFromIsoStringWithTimeZone($isoString, $expectedString, $expectedTimeZone)
    {
        $result = Date::fromIsoString($isoString);
        $this->assertSame($expectedString, $result->isoString());
        $this->assertEquals($expectedTimeZone, $result->timeZone());
    }

    public function validIsoStringsWithTimeZone()
    {
        $hours = 60 * 60;
        $minutes = 60;

        $timeZoneUTC = new TimeZone(0);
        $timeZonePos1100 = new TimeZone(11 * $hours);
        $timeZonePos1122 = new TimeZone((11 * $hours) + (22 * $minutes));
        $timeZoneNeg1100 = new TimeZone(-(11 * $hours));
        $timeZoneNeg1122 = new TimeZone(-((11 * $hours) + (22 * $minutes)));

        return array(
            'Basic UTC'               => array('20130201Z',        '2013-02-01', $timeZoneUTC),
            'Basic positive short'    => array('20130201+11',      '2013-02-01', $timeZonePos1100),
            'Basic positive long'     => array('20130201+1122',    '2013-02-01', $timeZonePos1122),
            'Basic negative short'    => array('20130201-11',      '2013-02-01', $timeZoneNeg1100),
            'Basic negative long'     => array('20130201-1122',    '2013-02-01', $timeZoneNeg1122),
            'Extended UTC'            => array('2013-02-01Z',      '2013-02-01', $timeZoneUTC),
            'Extended positive short' => array('2013-02-01+11',    '2013-02-01', $timeZonePos1100),
            'Extended positive long'  => array('2013-02-01+11:22', '2013-02-01', $timeZonePos1122),
            'Extended negative short' => array('2013-02-01-11',    '2013-02-01', $timeZoneNeg1100),
            'Extended negative long'  => array('2013-02-01-11:22', '2013-02-01', $timeZoneNeg1122),
        );
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoDate($isoString, $expected)
    {
        $this->setExpectedException('InvalidArgumentException', $expected);
        Date::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return array(
            'Not enough digits'                  => array('1',            'Invalid ISO date: "1"'),
            'Not enough digits'                  => array('000000',       'Invalid ISO date: "00-00-00"'),
            'Not enough digits'                  => array('112233',       'Invalid ISO date: "11-22-33"'),
            'Not enough digits'                  => array('00-00-00',     'Invalid ISO date: "00-00-00"'),
            'Not enough digits'                  => array('11-22-33',     'Invalid ISO date: "11-22-33"'),
            'Too many digits, invalid time zone' => array('111122334',    'Invalid ISO date: "4"'),
            'Too many digits, invalid time zone' => array('1111-22-33-4', 'Invalid ISO time zone: "-4"'),
            'Missing month and day'              => array('2013',         'Invalid ISO date: "2013"'),
            'Missing day'                        => array('201302',       'Invalid ISO date: "201302"'),
            'Missing day'                        => array('2013-02',      'Invalid ISO date: "2013-02"'),
            'Unexpected prefix'                  => array('-1111-22-33',  'Invalid ISO date: "-1111-22-33"'),
            'Invalid format'                     => array('00-00-0000',   'Invalid ISO date: ""'),
            'Invalid format'                     => array('11-22-3333',   'Invalid ISO date: "11-22-3333"'),
            'Invalid letters'                    => array('AAAABBCC',     'Invalid ISO date: "AAAABBCC"'),
            'Invalid letters'                    => array('AABBCC',       'Invalid ISO date: "AABBCC"'),
            'Invalid letters'                    => array('AAAA-BB-CC',   'Invalid ISO date: "AAAA-BB-CC"'),
            'Invalid letters'                    => array('AA-BB-CC',     'Invalid ISO date: "AA-BB-CC"'),
            'Invalid letters'                    => array('AA-BB-CCCC',   'Invalid ISO date: "AA-BB-CCCC"'),
            'Invalid letters'                    => array('AAAA-01-01',   'Invalid ISO date: "AAAA-01-01"'),
            'Invalid letters'                    => array('2013-BB-01',   'Invalid ISO date: "2013-BB-01"'),
            'Invalid letters'                    => array('2013-01-CC',   'Invalid ISO date: "2013-01-CC"'),
            'Invalid separator'                  => array('2013:02:01',   'Invalid ISO date: "2013:02:01"'),
            'Missing date'                       => array('+10',          'Invalid ISO date: "+10"'),
            'Missing date'                       => array('+10:20',       'Invalid ISO date: "+10:20"'),
        );
    }
}
