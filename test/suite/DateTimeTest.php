<?php

namespace Icecave\Chrono;

use DateTime as NativeDateTime;
use Eloquent\Liberator\Liberator;
use Phake;
use PHPUnit\Framework\TestCase;

/**
 * @covers Icecave\Chrono\DateTime
 * @covers Icecave\Chrono\Detail\Iso8601
 */
class DateTimeTest extends TestCase
{
    public function setUp(): void
    {
        $this->dateTime = new DateTime(2013, 2, 1, 10, 20, 30);
    }

    public function testNormalization()
    {
        $dateTime = new DateTime(2013, 1, 32, 10, 20, 70);
        $this->assertSame('2013-02-01T10:21:10+00:00', $dateTime->isoString());
    }

    public function testYear()
    {
        $this->assertSame(2013, $this->dateTime->year());
    }

    public function testMonth()
    {
        $this->assertSame(2, $this->dateTime->month());
    }

    public function testDay()
    {
        $this->assertSame(1, $this->dateTime->day());
    }

    public function testHour()
    {
        $this->assertSame(10, $this->dateTime->hour());
    }

    public function testMinute()
    {
        $this->assertSame(20, $this->dateTime->minute());
    }

    public function testSecond()
    {
        $this->assertSame(30, $this->dateTime->second());
    }

    public function testToTimeZone()
    {
        $timeZone = new TimeZone(36000);
        $result   = $this->dateTime->toTimeZone($timeZone);

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $result);
        $this->assertSame('2013-02-01T20:20:30+10:00', $result->isoString());
    }

    public function testToTimeZoneSame()
    {
        $result = $this->dateTime->toTimeZone(new TimeZone());
        $this->assertSame($this->dateTime, $result);
    }

    public function testToUtc()
    {
        $timeZone = new TimeZone(36000);
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, $timeZone);
        $result   = $dateTime->toUtc();

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $result);
        $this->assertSame('2013-02-01T00:20:30+00:00', $result->isoString());
    }

    public function testTimeZone()
    {
        $this->assertTrue($this->dateTime->timeZone()->isUtc());

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
        $expected = new TimeOfDay(10, 20, 30, $timeZone);
        $result   = $dateTime->time();

        $this->assertEquals($expected, $result);
    }

    public function testCompareSelf()
    {
        $this->assertSame(0, $this->dateTime->compare($this->dateTime));
    }

    public function testCompareClone()
    {
        $dateTime = clone $this->dateTime;
        $this->assertSame(0, $this->dateTime->compare($dateTime));
    }

    public function testCompareDateTime()
    {
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 31);
        $this->assertLessThan(0, $this->dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->dateTime));

        $dateTime = new DateTime(2013, 2, 1, 10, 21, 30);
        $this->assertLessThan(0, $this->dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->dateTime));

        $dateTime = new DateTime(2013, 2, 1, 11, 20, 30);
        $this->assertLessThan(0, $this->dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->dateTime));

        $dateTime = new DateTime(2013, 2, 2, 10, 20, 30);
        $this->assertLessThan(0, $this->dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->dateTime));

        $dateTime = new DateTime(2013, 3, 1, 10, 20, 30);
        $this->assertLessThan(0, $this->dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->dateTime));

        $dateTime = new DateTime(2014, 2, 1, 10, 20, 30);
        $this->assertLessThan(0, $this->dateTime->compare($dateTime));
        $this->assertGreaterThan(0, $dateTime->compare($this->dateTime));
    }

    public function testCompareTimeZone()
    {
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, new TimeZone(36000));
        $this->assertLessThan(0, $dateTime->compare($this->dateTime));
        $this->assertGreaterThan(0, $this->dateTime->compare($dateTime));
    }

    public function testCompareOther()
    {
        $timePoint = Phake::mock(__NAMESPACE__ . '\TimePointInterface');
        Phake::when($timePoint)
            ->unixTime()
            ->thenReturn(1359714031);

        $this->assertLessThan(0, $this->dateTime->compare($timePoint));
    }

    public function testUnixTime()
    {
        $this->assertSame(1359714030, $this->dateTime->unixTime());
    }

    public function testUnixTimeWithTimeZone()
    {
        $timeZone = new TimeZone(36000, true);
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, $timeZone);

        $this->assertSame(1359678030, $dateTime->unixTime());
    }

    public function testFromUnixTime()
    {
        $dateTime = DateTime::fromUnixTime(1359714030);
        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $dateTime);
        $this->assertSame('2013-02-01T10:20:30+00:00', $dateTime->isoString());
    }

    public function testFromUnixTimeWithTimeZone()
    {
        $timeZone = new TimeZone(36000, true);
        $dateTime = DateTime::fromUnixTime(1359714030, $timeZone);
        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $dateTime);
        $this->assertSame('2013-02-01T20:20:30+10:00', $dateTime->isoString());
    }

    public function testFromNativeDateTime()
    {
        $native   = new NativeDateTime('2013-02-01T20:20:30+10:00');
        $dateTime = DateTime::fromNativeDateTime($native);
        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $dateTime);
        $this->assertSame('2013-02-01T20:20:30+10:00', $dateTime->isoString());
    }

    /**
     * @group regression
     * @link https://github.com/IcecaveStudios/chrono/issues/92
     */
    public function testFromNativeDateTimeWithTimeZoneAbbreviation()
    {
        $this->assertEquals(
            new TimeZone(
                -25200,
                true
            ),
            DateTime::fromNativeDateTime(
                new NativeDateTime('2014-10-11 12:13:14 PDT')
            )->timeZone()
        );

        $this->assertEquals(
            new TimeZone(
                -28800,
                false
            ),
            DateTime::fromNativeDateTime(
                new NativeDateTime('2014-10-11 12:13:14 PST')
            )->timeZone()
        );
    }

    public function testNativeDateTime()
    {
        $timeZone = new TimeZone(36000, true);
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 30, $timeZone);

        $native = $dateTime->nativeDateTime();
        $this->assertInstanceOf('DateTime', $native);
        $this->assertSame('2013-02-01T10:20:30+10:00', $native->format('c'));
    }

    public function testAdd()
    {
        $duration = Phake::partialMock('Icecave\Chrono\TimeSpan\TimeSpanInterface');
        $expected = DateTime::fromIsoString('2013-01-31T10:20:30+00:00');

        Phake::when($duration)
            ->resolveToTimePoint($this->dateTime)
            ->thenReturn($expected);

        $dateTime = $this->dateTime->add($duration);

        $this->assertSame($expected, $dateTime);
    }

    public function testAddWithSeconds()
    {
        $dateTime = $this->dateTime->add(86400);

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $dateTime);
        $this->assertSame('2013-02-02T10:20:30+00:00', $dateTime->isoString());
    }

    public function testSubtract()
    {
        $duration = Phake::partialMock('Icecave\Chrono\TimeSpan\TimeSpanInterface');
        $expected = DateTime::fromIsoString('2013-01-31T10:20:30+00:00');

        Phake::when($duration)
            ->inverse()
            ->thenReturn($duration);

        Phake::when($duration)
            ->resolveToTimePoint($this->dateTime)
            ->thenReturn($expected);

        $dateTime = $this->dateTime->subtract($duration);

        $this->assertSame($expected, $dateTime);

        Phake::verify($duration)->inverse();
    }

    public function testSubtractWithSeconds()
    {
        $dateTime = $this->dateTime->subtract(86400);

        $this->assertInstanceOf(__NAMESPACE__ . '\DateTime', $dateTime);
        $this->assertSame('2013-01-31T10:20:30+00:00', $dateTime->isoString());
    }

    public function testDifferenceAsSeconds()
    {
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 0);
        $diff     = $this->dateTime->differenceAsSeconds($dateTime);
        $this->assertSame(30, $diff);
    }

    public function testDifferenceAsDuration()
    {
        $dateTime = new DateTime(2013, 2, 1, 10, 20, 0);
        $duration = $this->dateTime->differenceAsDuration($dateTime);

        $this->assertInstanceOf('Icecave\Chrono\TimeSpan\Duration', $duration);
        $this->assertSame(30, $duration->totalSeconds());
    }

    public function testFormat()
    {
        $formatter                                                                     = Phake::mock(__NAMESPACE__ . '\Format\FormatterInterface');
        Liberator::liberateClass(__NAMESPACE__ . '\Format\DefaultFormatter')->instance = $formatter;

        Phake::when($formatter)
            ->formatDateTime(Phake::anyParameters())
            ->thenReturn('<1st>')
            ->thenReturn('<2nd>');

        $result = $this->dateTime->format('Y-m-d H:i:s');
        $this->assertSame('<1st>', $result);

        $result = $this->dateTime->format('Y-m-d H:i:s', $formatter);
        $this->assertSame('<2nd>', $result);

        Phake::verify($formatter, Phake::times(2))->formatDateTime($this->dateTime, 'Y-m-d H:i:s');
    }

    public function testIsoString()
    {
        $this->assertEquals('2013-02-01T10:20:30+00:00', $this->dateTime->isoString());
        $this->assertEquals('2013-02-01T10:20:30+00:00', $this->dateTime->__toString());
    }

    /**
     * @dataProvider validIsoStrings
     */
    public function testFromIsoString($isoString, $expected)
    {
        $result = DateTime::fromIsoString($isoString);
        $this->assertSame($expected, $result->isoString());
    }

    public function validIsoStrings()
    {
        return array(
            'Basic with T'                        => array('20130201T102030',          '2013-02-01T10:20:30+00:00'),
            'Basic with T, partial seconds'       => array('20130201T102030.1234',     '2013-02-01T10:20:30+00:00'),

            'Basic without T'                     => array('20130201 102030',          '2013-02-01T10:20:30+00:00'),
            'Basic without T, partial seconds'    => array('20130201 102030.1234',     '2013-02-01T10:20:30+00:00'),

            'Extended with T'                     => array('2013-02-01T10:20:30',      '2013-02-01T10:20:30+00:00'),
            'Extended with T, partial seconds'    => array('2013-02-01T10:20:30.1234', '2013-02-01T10:20:30+00:00'),

            'Extended without T'                  => array('2013-02-01 10:20:30',      '2013-02-01T10:20:30+00:00'),
            'Extended without T, partial seconds' => array('2013-02-01 10:20:30.1234', '2013-02-01T10:20:30+00:00'),
        );
    }

    /**
     * @dataProvider validIsoStringsWithTimeZone
     */
    public function testFromIsoStringWithTimeZone($isoString, $expectedString, $expectedTimeZone)
    {
        $result = DateTime::fromIsoString($isoString);
        $this->assertSame($expectedString, $result->isoString());
        $this->assertEquals($expectedTimeZone, $result->timeZone());
    }

    public function validIsoStringsWithTimeZone()
    {
        $hours   = 60 * 60;
        $minutes = 60;

        $timeZoneUTC     = new TimeZone(0);
        $timeZonePos1100 = new TimeZone(11 * $hours);
        $timeZonePos1122 = new TimeZone((11 * $hours) + (22 * $minutes));
        $timeZoneNeg1100 = new TimeZone(-(11 * $hours));
        $timeZoneNeg1122 = new TimeZone(-((11 * $hours) + (22 * $minutes)));

        return array(
            'Basic with T, UTC'                   => array('20130201T102030Z',               '2013-02-01T10:20:30+00:00', $timeZoneUTC),
            'Basic with T, positive short'        => array('20130201T102030+11',             '2013-02-01T10:20:30+11:00', $timeZonePos1100),
            'Basic with T, positive long'         => array('20130201T102030+1122',           '2013-02-01T10:20:30+11:22', $timeZonePos1122),
            'Basic with T, negative short'        => array('20130201T102030-11',             '2013-02-01T10:20:30-11:00', $timeZoneNeg1100),
            'Basic with T, negative long'         => array('20130201T102030-1122',           '2013-02-01T10:20:30-11:22', $timeZoneNeg1122),
            'Basic with T, partial seconds'       => array('20130201T102030.1234-1122',      '2013-02-01T10:20:30-11:22', $timeZoneNeg1122),

            'Extended with T, UTC'                => array('2013-02-01T10:20:30Z',           '2013-02-01T10:20:30+00:00', $timeZoneUTC),
            'Extended with T, positive short'     => array('2013-02-01T10:20:30+11',         '2013-02-01T10:20:30+11:00', $timeZonePos1100),
            'Extended with T, positive long'      => array('2013-02-01T10:20:30+11:22',      '2013-02-01T10:20:30+11:22', $timeZonePos1122),
            'Extended with T, negative short'     => array('2013-02-01T10:20:30-11',         '2013-02-01T10:20:30-11:00', $timeZoneNeg1100),
            'Extended with T, negative long'      => array('2013-02-01T10:20:30-11:22',      '2013-02-01T10:20:30-11:22', $timeZoneNeg1122),
            'Extended with T, partial seconds'    => array('2013-02-01T10:20:30.1234-11:22', '2013-02-01T10:20:30-11:22', $timeZoneNeg1122),

            'Basic without T, UTC'                => array('20130201 102030Z',               '2013-02-01T10:20:30+00:00', $timeZoneUTC),
            'Basic without T, positive short'     => array('20130201 102030+11',             '2013-02-01T10:20:30+11:00', $timeZonePos1100),
            'Basic without T, positive long'      => array('20130201 102030+1122',           '2013-02-01T10:20:30+11:22', $timeZonePos1122),
            'Basic without T, negative short'     => array('20130201 102030-11',             '2013-02-01T10:20:30-11:00', $timeZoneNeg1100),
            'Basic without T, negative long'      => array('20130201 102030-1122',           '2013-02-01T10:20:30-11:22', $timeZoneNeg1122),
            'Basic without T, partial seconds'    => array('20130201 102030.1234-1122',      '2013-02-01T10:20:30-11:22', $timeZoneNeg1122),

            'Extended without T, UTC'             => array('2013-02-01 10:20:30Z',           '2013-02-01T10:20:30+00:00', $timeZoneUTC),
            'Extended without T, positive short'  => array('2013-02-01 10:20:30+11',         '2013-02-01T10:20:30+11:00', $timeZonePos1100),
            'Extended without T, positive long'   => array('2013-02-01 10:20:30+11:22',      '2013-02-01T10:20:30+11:22', $timeZonePos1122),
            'Extended without T, negative short'  => array('2013-02-01 10:20:30-11',         '2013-02-01T10:20:30-11:00', $timeZoneNeg1100),
            'Extended without T, negative long'   => array('2013-02-01 10:20:30-11:22',      '2013-02-01T10:20:30-11:22', $timeZoneNeg1122),
            'Extended without T, partial seconds' => array('2013-02-01 10:20:30.1234-11:22', '2013-02-01T10:20:30-11:22', $timeZoneNeg1122),
        );
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoDateTime($isoString, $expected)
    {
        $this->expectException('InvalidArgumentException', $expected);
        DateTime::fromIsoString($isoString);
    }

    public function invalidIsoStrings()
    {
        return array(
            'Not enough digits'                  => array('1',                     'Invalid ISO date time: "1"'),
            'Not enough digits'                  => array('000000T000000',         'Invalid ISO date time: "00-00-00T00:00:00"'),
            'Not enough digits'                  => array('112233T445566',         'Invalid ISO date time: "11-22-33T00:00:00"'),
            'Not enough digits'                  => array('00-00-00 00:00:00',     'Invalid ISO date time: "00-00-00 00:00:00"'),
            'Not enough digits'                  => array('11-22-33 11:22:33',     'Invalid ISO date time: "11-22-33 11:22:33"'),
            'Too many digits, invalid time zone' => array('11112233T4455667',      'Invalid ISO date time: "7"'),
            'Too many digits, invalid time zone' => array('1111-22-33T11:22:33:4', 'Invalid ISO time zone: ":4"'),
            'Missing month and day'              => array('2013',                  'Invalid ISO date time: "2013"'),
            'Missing day'                        => array('201302',                'Invalid ISO date time: "201302"'),
            'Missing day'                        => array('2013-02',               'Invalid ISO date time: "2013-02"'),
            'Missing hour, minute and second'    => array('2013-02-01T',           'Invalid ISO date time: "2013-02-01T"'),
            'Missing minute'                     => array('20130201 10',           'Invalid ISO date time: "20130201 10"'),
            'Missing minute'                     => array('2013-02-01T10',         'Invalid ISO date time: "2013-02-01T10"'),
            'Missing second'                     => array('20130201 1020',         'Invalid ISO date time: "20130201 1020"'),
            'Missing second'                     => array('2013-02-01T10:20',      'Invalid ISO date time: "2013-02-01T10:20"'),
            'Unexpected prefix'                  => array('-1111-22-33 10:20:30',  'Invalid ISO date time: "-1111-22-33 10:20:30"'),
            'Invalid format'                     => array('00-00-0000 00:00:00',   'Invalid ISO date time: ""'),
            'Invalid format'                     => array('11-22-3333 00:00:00',   'Invalid ISO date time: "11-22-3333 00:00:00"'),
            'Invalid letters'                    => array('AAAABBCC DDEEFF',       'Invalid ISO date time: "AAAABBCC DDEEFF"'),
            'Invalid letters'                    => array('AAAABBCCTDDEEFF',       'Invalid ISO date time: "AAAABBCCTDDEEFF"'),
            'Invalid letters'                    => array('AABBCC DDEEFF',         'Invalid ISO date time: "AABBCC DDEEFF"'),
            'Invalid letters'                    => array('AAAA-BB-CC',            'Invalid ISO date time: "AAAA-BB-CC"'),
            'Invalid letters'                    => array('AA-BB-CCTDD:EE:FF',     'Invalid ISO date time: "AA-BB-CCTDD:EE:FF"'),
            'Invalid letters'                    => array('AA-BB-CCCC DD:EE:FF',   'Invalid ISO date time: "AA-BB-CCCC DD:EE:FF"'),
            'Invalid letters'                    => array('AAAA-01-01 10:20:30',   'Invalid ISO date time: "AAAA-01-01 10:20:30"'),
            'Invalid letters'                    => array('2013-BB-01 10:20:30',   'Invalid ISO date time: "2013-BB-01 10:20:30"'),
            'Invalid letters'                    => array('2013-01-CC 10:20:30',   'Invalid ISO date time: "2013-01-CC 10:20:30"'),
            'Invalid letters'                    => array('2013-01-01 DD:20:30',   'Invalid ISO date time: "2013-01-01 DD:20:30"'),
            'Invalid letters'                    => array('2013-01-01 10:EE:30',   'Invalid ISO date time: "2013-01-01 10:EE:30"'),
            'Invalid letters'                    => array('2013-01-01 10:20:FF',   'Invalid ISO date time: "2013-01-01 10:20:FF"'),
            'Invalid separator'                  => array('2013:02:01 10-20-30',   'Invalid ISO date time: "2013:02:01 10-20-30"'),
            'Invalid separator'                  => array('2013/02/01 10:20:30',   'Invalid ISO date time: "2013/02/01 10:20:30"'),
            'Missing date'                       => array('10:20:30+10',           'Invalid ISO date time: "10:20:30+10"'),
            'Missing date'                       => array('10:20:30+10:20',        'Invalid ISO date time: "10:20:30+10:20"'),
            'Missing time'                       => array('2013-02-01+10',         'Invalid ISO date time: "2013-02-01+10"'),
            'Missing time'                       => array('2013-02-01+10:20',      'Invalid ISO date time: "2013-02-01+10:20"'),
            'Missing date and time'              => array('+10',                   'Invalid ISO date time: "+10"'),
            'Missing date and time'              => array('+10:20',                'Invalid ISO date time: "+10:20"'),
        );
    }
}
