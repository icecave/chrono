<?php
namespace Icecave\Chrono\Support;

use PHPUnit_Framework_TestCase;

class Iso8601Test extends PHPUnit_Framework_TestCase
{
    public function testFormatDate()
    {
        $this->assertSame('2013-02-01', Iso8601::formatDate(2013,  2,  1));
        $this->assertSame('2013-12-25', Iso8601::formatDate(2013, 12, 25));
    }

    public function testFormatTime()
    {
        $this->assertSame('01:02:03+00:00', Iso8601::formatTime( 1,  2,  3, '+00:00'));
        $this->assertSame('11:22:33+00:00', Iso8601::formatTime(11, 22, 33, '+00:00'));
    }

    public function testFormatDateTime()
    {
        $this->assertSame('2013-02-01T01:02:03+00:00', Iso8601::formatDateTime(2013,  2,  1,  1,  2,  3, '+00:00'));
        $this->assertSame('2013-12-25T11:22:33+00:00', Iso8601::formatDateTime(2013, 12, 25, 11, 22, 33, '+00:00'));
    }

    public function testFormatTimeZone()
    {
        $this->assertSame('+00:00', Iso8601::formatTimeZone(    0));
        $this->assertSame('+00:30', Iso8601::formatTimeZone( 1800));
        $this->assertSame('+10:00', Iso8601::formatTimeZone(36000));
        $this->assertSame('+10:30', Iso8601::formatTimeZone(37800));

        $this->assertSame('+00:00', Iso8601::formatTimeZone(    0, false));
        $this->assertSame('+00:30', Iso8601::formatTimeZone( 1800, false));
        $this->assertSame('+10:00', Iso8601::formatTimeZone(36000, false));
        $this->assertSame('+10:30', Iso8601::formatTimeZone(37800, false));

        $this->assertSame('Z',      Iso8601::formatTimeZone(    0, true));
        $this->assertSame('+00:30', Iso8601::formatTimeZone( 1800, true));
        $this->assertSame('+10:00', Iso8601::formatTimeZone(36000, true));
        $this->assertSame('+10:30', Iso8601::formatTimeZone(37800, true));

        $this->assertSame('+00:00', Iso8601::formatTimeZone(    -0));
        $this->assertSame('-00:30', Iso8601::formatTimeZone( -1800));
        $this->assertSame('-10:00', Iso8601::formatTimeZone(-36000));
        $this->assertSame('-10:30', Iso8601::formatTimeZone(-37800));

        $this->assertSame('+00:00', Iso8601::formatTimeZone(    -0, false));
        $this->assertSame('-00:30', Iso8601::formatTimeZone( -1800, false));
        $this->assertSame('-10:00', Iso8601::formatTimeZone(-36000, false));
        $this->assertSame('-10:30', Iso8601::formatTimeZone(-37800, false));

        $this->assertSame('Z',      Iso8601::formatTimeZone(    -0, true));
        $this->assertSame('-00:30', Iso8601::formatTimeZone( -1800, true));
        $this->assertSame('-10:00', Iso8601::formatTimeZone(-36000, true));
        $this->assertSame('-10:30', Iso8601::formatTimeZone(-37800, true));
    }

    public function testFormatDuration()
    {
        $this->assertSame('P',                  Iso8601::formatDuration(0, 0, 0, 0, 0, 0));
        $this->assertSame('P1Y2M3DT4H5M6S',     Iso8601::formatDuration(1, 2, 3, 4, 5, 6));

        $this->assertSame('P1Y',                Iso8601::formatDuration(1, 0, 0, 0, 0, 0));
        $this->assertSame('P1M',                Iso8601::formatDuration(0, 1, 0, 0, 0, 0));
        $this->assertSame('P1D',                Iso8601::formatDuration(0, 0, 1, 0, 0, 0));
        $this->assertSame('PT1H',               Iso8601::formatDuration(0, 0, 0, 1, 0, 0));
        $this->assertSame('PT1M',               Iso8601::formatDuration(0, 0, 0, 0, 1, 0));
        $this->assertSame('PT1S',               Iso8601::formatDuration(0, 0, 0, 0, 0, 1));

        $this->assertSame('P1Y2M',              Iso8601::formatDuration(1, 2, 0, 0, 0, 0));
        $this->assertSame('P1M2D',              Iso8601::formatDuration(0, 1, 2, 0, 0, 0));
        $this->assertSame('P1DT2H',             Iso8601::formatDuration(0, 0, 1, 2, 0, 0));
        $this->assertSame('PT1H2M',             Iso8601::formatDuration(0, 0, 0, 1, 2, 0));
        $this->assertSame('PT1M2S',             Iso8601::formatDuration(0, 0, 0, 0, 1, 2));
        $this->assertSame('PT2M1S',             Iso8601::formatDuration(0, 0, 0, 0, 2, 1));

        $this->assertSame('P1Y2MT33S',          Iso8601::formatDuration(1, 2, 0, 0, 0, 33));
        $this->assertSame('P1M2DT33S',          Iso8601::formatDuration(0, 1, 2, 0, 0, 33));
        $this->assertSame('P1DT2H33S',          Iso8601::formatDuration(0, 0, 1, 2, 0, 33));
        $this->assertSame('PT1H2M33S',          Iso8601::formatDuration(0, 0, 0, 1, 2, 33));
        $this->assertSame('PT1M33S',            Iso8601::formatDuration(0, 0, 0, 0, 1, 33));
        $this->assertSame('PT2M33S',            Iso8601::formatDuration(0, 0, 0, 0, 2, 33));
    }

    public function testFormatIntervalDateTimes()
    {
        $result = Iso8601::formatIntervalDateTimes('2013-01-01T10:20:30+00:00', '2013-01-30T20:20:30+00:00');

        $this->assertSame('2013-01-01T10:20:30+00:00/2013-01-30T20:20:30+00:00', $result);
    }

    public function testFormatIntervalDateTimeParts()
    {
        $result = Iso8601::formatIntervalDateTimeParts(
            2013, 1,  1, 10, 20, 30, '+12:34',
            2013, 1, 30, 20, 20, 30, '+12:34'
        );

        $this->assertSame('2013-01-01T10:20:30+12:34/2013-01-30T20:20:30+12:34', $result);
    }

    public function testFormatIntervalDateTimeAndDuration()
    {
        $result = Iso8601::formatIntervalDateTimeAndDuration(
            '2013-01-01T10:20:30+12:34',
            'P1DT2H'
        );

        $this->assertSame('2013-01-01T10:20:30+12:34/P1DT2H', $result);
    }

    public function testFormatIntervalDateTimePartsAndDuration()
    {
        $result = Iso8601::formatIntervalDateTimePartsAndDuration(
            2013, 1,  1, 10, 20, 30, '+12:34',
            'P1DT2H'
        );

        $this->assertSame('2013-01-01T10:20:30+12:34/P1DT2H', $result);
    }

    public function testFormatIntervalDateTimeAndDurationParts()
    {
        $result = Iso8601::formatIntervalDateTimeAndDurationParts(
            '2013-01-01T10:20:30+12:34',
            1, 2, 3, 4, 5, 6
        );

        $this->assertSame('2013-01-01T10:20:30+12:34/P1Y2M3DT4H5M6S', $result);
    }

    public function testFormatIntervalDateTimePartsAndDurationParts()
    {
        $result = Iso8601::formatIntervalDateTimePartsAndDurationParts(
            2013, 1,  1, 10, 20, 30, '+12:34',
            1, 2, 3, 4, 5, 6
        );

        $this->assertSame('2013-01-01T10:20:30+12:34/P1Y2M3DT4H5M6S', $result);
    }

    /**
     * @dataProvider validIsoDateStrings
     */
    public function testParseDate($isoString, $expected)
    {
        $result = Iso8601::parseDate($isoString);
        $this->assertSame($expected, $result);
    }

    public function validIsoDateStrings()
    {
        return array(
            'Basic'    => array('20130201',   array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' => null)),
            'Extended' => array('2013-02-01', array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' => null)),
        );
    }

    /**
     * @dataProvider validIsoDateStringsWithTimeZone
     */
    public function testParseDateWithTimeZone($isoString, $expected)
    {
        $result = Iso8601::parseDate($isoString);
        $this->assertSame($expected, $result);
    }

    public function validIsoDateStringsWithTimeZone()
    {
        $hours = 60 * 60;
        $minutes = 60;

        $offset1100 = 11 * $hours;
        $offset1122 = (11 * $hours) + (22 * $minutes);

        return array(
            'Basic UTC'               => array('20130201Z',        array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' =>  0)),
            'Basic positive short'    => array('20130201+11',      array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' =>  $offset1100)),
            'Basic positive long'     => array('20130201+1122',    array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' =>  $offset1122)),
            'Basic negative short'    => array('20130201-11',      array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' => -$offset1100)),
            'Basic negative long'     => array('20130201-1122',    array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' => -$offset1122)),
            'Extended UTC'            => array('2013-02-01Z',      array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' =>  0)),
            'Extended positive short' => array('2013-02-01+11',    array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' =>  $offset1100)),
            'Extended positive long'  => array('2013-02-01+11:22', array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' =>  $offset1122)),
            'Extended negative short' => array('2013-02-01-11',    array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' => -$offset1100)),
            'Extended negative long'  => array('2013-02-01-11:22', array('year' => 2013, 'month' => 2, 'day' => 1, 'offset' => -$offset1122)),
        );
    }

    /**
     * @dataProvider invalidIsoDateStrings
     */
    public function testParseDateWithInvalidIsoDate($isoString, $expected)
    {
        $this->setExpectedException('InvalidArgumentException', $expected);
        Iso8601::parseDate($isoString);
    }

    public function invalidIsoDateStrings()
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

    /**
     * @dataProvider validIsoTimeStrings
     */
    public function testParseTime($isoString, $expected)
    {
        $result = Iso8601::parseTime($isoString);
        $this->assertSame($expected, $result);
    }

    public function validIsoTimeStrings()
    {
        return array(
            'Basic'    => array('102030',   array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => null)),
            'Extended' => array('10:20:30', array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => null)),
        );
    }

    /**
     * @dataProvider validIsoTimeStringsWithTimeZone
     */
    public function testParseTimeWithTimeZone($isoString, $expected)
    {
        $result = Iso8601::parseTime($isoString);
        $this->assertSame($expected, $result);
    }

    public function validIsoTimeStringsWithTimeZone()
    {
        $hours = 60 * 60;
        $minutes = 60;

        $offset1100 = 11 * $hours;
        $offset1122 = (11 * $hours) + (22 * $minutes);

        return array(
            'Basic, UTC'               => array('102030Z',        array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  0)),
            'Basic, positive short'    => array('102030+11',      array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1100)),
            'Basic, positive long'     => array('102030+1122',    array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1122)),
            'Basic, negative short'    => array('102030-11',      array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1100)),
            'Basic, negative long'     => array('102030-1122',    array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1122)),
            'Extended, UTC'            => array('10:20:30Z',      array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  0)),
            'Extended, positive short' => array('10:20:30+11',    array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1100)),
            'Extended, positive long'  => array('10:20:30+11:22', array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1122)),
            'Extended, negative short' => array('10:20:30-11',    array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1100)),
            'Extended, negative long'  => array('10:20:30-11:22', array('hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1122)),
        );
    }

    /**
     * @dataProvider invalidIsoTimeStrings
     */
    public function testParseTimeWithInvalidIsoTime($isoString, $expected)
    {
        $this->setExpectedException('InvalidArgumentException', $expected);
        Iso8601::parseTime($isoString);
    }

    public function invalidIsoTimeStrings()
    {
        return array(
            'Not enough digits'                  => array('1',          'Invalid ISO time: "1"'),
            'Not enough digits'                  => array('00000',      'Invalid ISO time: "00:00:0"'),
            'Not enough digits'                  => array('11223',      'Invalid ISO time: "00:00:0"'),
            'Not enough digits'                  => array('00:00:0',    'Invalid ISO time: "00:00:0"'),
            'Not enough digits'                  => array('11:22:3',    'Invalid ISO time: "11:22:3"'),
            'Too many digits, invalid time zone' => array('1122334',    'Invalid ISO time: "4"'),
            'Too many digits, invalid time zone' => array('11:22:33:4', 'Invalid ISO time zone: ":4"'),
            'Missing minute and second'          => array('11',         'Invalid ISO time: "11"'),
            'Missing second'                     => array('1122',       'Invalid ISO time: "11:22"'),
            'Missing second'                     => array('11:22',      'Invalid ISO time: "11:22"'),
            'Unexpected prefix'                  => array('-10:20:30',  'Invalid ISO time: "-10:20:30"'),
            'Invalid format'                     => array('11:',        'Invalid ISO time: "11:"'),
            'Invalid format'                     => array('11:22:',     'Invalid ISO time: "11:22:"'),
            'Invalid letters'                    => array('AABBCC',     'Invalid ISO time: "AABBCC"'),
            'Invalid letters'                    => array('AA:BB:CC',   'Invalid ISO time: "AA:BB:CC"'),
            'Invalid letters'                    => array('AA:22:33',   'Invalid ISO time: "AA:22:33"'),
            'Invalid letters'                    => array('11:BB:33',   'Invalid ISO time: "11:BB:33"'),
            'Invalid letters'                    => array('11:22:CC',   'Invalid ISO time: "11:22:CC"'),
            'Invalid separator'                  => array('11-22-33',   'Invalid ISO time: "11-22-33"'),
            'Missing time'                       => array('+10',        'Invalid ISO time: "+10"'),
            'Missing time'                       => array('+10:20',     'Invalid ISO time: "+10:20"'),
        );
    }

    /**
     * @dataProvider validIsoDateTimeStrings
     */
    public function testParseDateTime($isoString, $expected)
    {
        $result = Iso8601::parseDateTime($isoString);
        $this->assertSame($expected, $result);
    }

    public function validIsoDateTimeStrings()
    {
        return array(
            'Basic with T'       => array('20130201T102030',     array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => null)),
            'Basic without T'    => array('20130201 102030',     array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => null)),
            'Extended with T'    => array('2013-02-01T10:20:30', array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => null)),
            'Extended without T' => array('2013-02-01 10:20:30', array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => null)),
        );
    }

    /**
     * @dataProvider validIsoDateTimeStringsWithTimeZone
     */
    public function testParseDateTimeWithTimeZone($isoString, $expected)
    {
        $result = Iso8601::parseDateTime($isoString);
        $this->assertSame($expected, $result);
    }

    public function validIsoDateTimeStringsWithTimeZone()
    {
        $hours = 60 * 60;
        $minutes = 60;

        $offset1100 = 11 * $hours;
        $offset1122 = (11 * $hours) + (22 * $minutes);

        return array(
            'Basic with T, UTC'                  => array('20130201T102030Z',          array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  0)),
            'Basic with T, positive short'       => array('20130201T102030+11',        array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1100)),
            'Basic with T, positive long'        => array('20130201T102030+1122',      array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1122)),
            'Basic with T, negative short'       => array('20130201T102030-11',        array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1100)),
            'Basic with T, negative long'        => array('20130201T102030-1122',      array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1122)),
            'Extended with T, UTC'               => array('2013-02-01T10:20:30Z',      array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  0)),
            'Extended with T, positive short'    => array('2013-02-01T10:20:30+11',    array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1100)),
            'Extended with T, positive long'     => array('2013-02-01T10:20:30+11:22', array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1122)),
            'Extended with T, negative short'    => array('2013-02-01T10:20:30-11',    array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1100)),
            'Extended with T, negative long'     => array('2013-02-01T10:20:30-11:22', array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1122)),
            'Basic without T, UTC'               => array('20130201 102030Z',          array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  0)),
            'Basic without T, positive short'    => array('20130201 102030+11',        array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1100)),
            'Basic without T, positive long'     => array('20130201 102030+1122',      array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1122)),
            'Basic without T, negative short'    => array('20130201 102030-11',        array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1100)),
            'Basic without T, negative long'     => array('20130201 102030-1122',      array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1122)),
            'Extended without T, UTC'            => array('2013-02-01 10:20:30Z',      array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  0)),
            'Extended without T, positive short' => array('2013-02-01 10:20:30+11',    array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1100)),
            'Extended without T, positive long'  => array('2013-02-01 10:20:30+11:22', array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' =>  $offset1122)),
            'Extended without T, negative short' => array('2013-02-01 10:20:30-11',    array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1100)),
            'Extended without T, negative long'  => array('2013-02-01 10:20:30-11:22', array('year' => 2013, 'month' => 2, 'day' => 1, 'hour' => 10, 'minute' => 20, 'second' => 30, 'offset' => -$offset1122)),
        );
    }

    /**
     * @dataProvider invalidIsoStrings
     */
    public function testFromIsoStringWithInvalidIsoDateTime($isoString, $expected)
    {
        $this->setExpectedException('InvalidArgumentException', $expected);
        Iso8601::parseDateTime($isoString);
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
            'Missing date'                       => array('10:20:30+10',           'Invalid ISO date time: "10:20:30+10"'),
            'Missing date'                       => array('10:20:30+10:20',        'Invalid ISO date time: "10:20:30+10:20"'),
            'Missing time'                       => array('2013-02-01+10',         'Invalid ISO date time: "2013-02-01+10"'),
            'Missing time'                       => array('2013-02-01+10:20',      'Invalid ISO date time: "2013-02-01+10:20"'),
            'Missing date and time'              => array('+10',                   'Invalid ISO date time: "+10"'),
            'Missing date and time'              => array('+10:20',                'Invalid ISO date time: "+10:20"'),
        );
    }

    /**
     * @dataProvider validIsoDurationStrings
     */
    public function testParseDuration($isoString, $expected)
    {
        $result = Iso8601::parseDuration($isoString);
        $this->assertSame($expected, $result);
    }

    public function validIsoDurationStrings()
    {
        return array(
            // Duration Format - Empty/Zero
            'Empty'                                     => array('P',                       array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Empty with T'                              => array('PT',                      array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero years ending with T'                  => array('P0YT',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero months ending with T'                 => array('P0MT',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero days ending with T'                   => array('P0DT',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero weeks'                                => array('P0W',                     array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero years'                                => array('P0Y',                     array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero months'                               => array('P0M',                     array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero days'                                 => array('P0D',                     array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero hours'                                => array('PT0H',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero minutes'                              => array('PT0M',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero seconds'                              => array('PT0S',                    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero YMD'                                  => array('P0Y0M0D',                 array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero HMS'                                  => array('PT0H0M0S',                array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero YMD HMS'                              => array('P0Y0M0DT0H0M0S',          array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Zero months and minutes'                   => array('P0MT0M',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),

            // Duration Format - Weeks
            'Weeks 1'                                   => array('P1W',                     array('years' => 0, 'months' => 0, 'days' =>  7, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Weeks 3'                                   => array('P3W',                     array('years' => 0, 'months' => 0, 'days' => 21, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Weeks 10'                                  => array('P10W',                    array('years' => 0, 'months' => 0, 'days' => 70, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Weeks zero prefix'                         => array('P03W',                    array('years' => 0, 'months' => 0, 'days' => 21, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),

            // Duration Format - Single digit
            'Years single digit'                         => array('P2Y',                    array('years' => 2, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months single digit'                        => array('P2M',                    array('years' => 0, 'months' => 2, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days single digit'                          => array('P2D',                    array('years' => 0, 'months' => 0, 'days' => 2, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Hours single digit'                         => array('PT2H',                   array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 2, 'minutes' => 0, 'seconds' => 0)),
            'Minutes single digit'                       => array('PT2M',                   array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 2, 'seconds' => 0)),
            'Seconds single digit'                       => array('PT2S',                   array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 2)),
            'Years single digit ending T'                => array('P2YT',                   array('years' => 2, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months single digit ending T'               => array('P2MT',                   array('years' => 0, 'months' => 2, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days single digit ending T'                 => array('P2DT',                   array('years' => 0, 'months' => 0, 'days' => 2, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),

            // Duration Format - Double digit
            'Years double digit'                         => array('P12Y',                   array('years' => 12, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Months double digit'                        => array('P12M',                   array('years' =>  0, 'months' => 12, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Days double digit'                          => array('P12D',                   array('years' =>  0, 'months' =>  0, 'days' => 12, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Hours double digit'                         => array('PT12H',                  array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' => 12, 'minutes' =>  0, 'seconds' =>  0)),
            'Minutes double digit'                       => array('PT12M',                  array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' => 12, 'seconds' =>  0)),
            'Seconds double digit'                       => array('PT12S',                  array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' => 12)),
            'Years double digit ending T'                => array('P12YT',                  array('years' => 12, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Months double digit ending T'               => array('P12MT',                  array('years' =>  0, 'months' => 12, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Days double digit ending T'                 => array('P12DT',                  array('years' =>  0, 'months' =>  0, 'days' => 12, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),

            // Duration Format - Single digit with zero prefix
            'Years single digit zero prefix'             => array('P05Y',                   array('years' => 5, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months single digit zero prefix'            => array('P05M',                   array('years' => 0, 'months' => 5, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days single digit zero prefix'              => array('P05D',                   array('years' => 0, 'months' => 0, 'days' => 5, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Hours single digit zero prefix'             => array('PT05H',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 5, 'minutes' => 0, 'seconds' => 0)),
            'Minutes single digit zero prefix'           => array('PT05M',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 5, 'seconds' => 0)),
            'Seconds single digit zero prefix'           => array('PT05S',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 5)),
            'Years single digit zero prefix ending T'    => array('P05YT',                  array('years' => 5, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months single digit zero prefix ending T'   => array('P05MT',                  array('years' => 0, 'months' => 5, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days single digit zero prefix ending T'     => array('P05DT',                  array('years' => 0, 'months' => 0, 'days' => 5, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),

            // Duration Format - Double digit with zero prefix
            'Years double digit zero prefix'             => array('P012Y',                  array('years' => 12, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Months double digit zero prefix'            => array('P012M',                  array('years' =>  0, 'months' => 12, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Days double digit zero prefix'              => array('P012D',                  array('years' =>  0, 'months' =>  0, 'days' => 12, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Hours double digit zero prefix'             => array('PT012H',                 array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' => 12, 'minutes' =>  0, 'seconds' =>  0)),
            'Minutes double digit zero prefix'           => array('PT012M',                 array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' => 12, 'seconds' =>  0)),
            'Seconds double digit zero prefix'           => array('PT012S',                 array('years' =>  0, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' => 12)),
            'Years double digit zero prefix ending T'    => array('P012YT',                 array('years' => 12, 'months' =>  0, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Months double digit zero prefix ending T'   => array('P012MT',                 array('years' =>  0, 'months' => 12, 'days' =>  0, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),
            'Days double digit zero prefix ending T'     => array('P012DT',                 array('years' =>  0, 'months' =>  0, 'days' => 12, 'hours' =>  0, 'minutes' =>  0, 'seconds' =>  0)),

            // Duration Format - Multiple periods
            'Years and months'                          => array('P2Y3M',                   array('years' => 2, 'months' => 3, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Months and days'                           => array('P2M3D',                   array('years' => 0, 'months' => 2, 'days' => 3, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Days and hours'                            => array('P2DT3H',                  array('years' => 0, 'months' => 0, 'days' => 2, 'hours' => 3, 'minutes' => 0, 'seconds' => 0)),
            'Hours and minutes'                         => array('PT2H3M',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 2, 'minutes' => 3, 'seconds' => 0)),
            'Minutes and seconds'                       => array('PT2M3S',                  array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 2, 'seconds' => 3)),
            'Seconds and years'                         => array('P3YT2S',                  array('years' => 3, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 2)),

            // Duration Format - Full periods
            'Full YMD'                                  => array('P1Y2M3D',                 array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Full YMD ending with T'                    => array('P1Y2M3DT',                array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Full HMS'                                  => array('PT4H5M6S',                array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 4, 'minutes' => 5, 'seconds' => 6)),
            'Full YMD HMS'                              => array('P1Y2M3DT4H5M6S',          array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 4, 'minutes' => 5, 'seconds' => 6)),

            // Date Time Format - Misc
            'Date time basic all zero'                  => array('P00000000T000000',        array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Date time extended all zero'               => array('P0000-00-00T00:00:00',    array('years' => 0, 'months' => 0, 'days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0)),
            'Date time basic'                           => array('P00010203T040506',        array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 4, 'minutes' => 5, 'seconds' => 6)),
            'Date time extended'                        => array('P0001-02-03T04:05:06',    array('years' => 1, 'months' => 2, 'days' => 3, 'hours' => 4, 'minutes' => 5, 'seconds' => 6)),
        );
    }

    /**
     * @dataProvider invalidIsoDurationStrings
     */
    public function testParseDurationWithInvalidIsoString($isoString, $expected)
    {
        $this->setExpectedException('InvalidArgumentException', $expected);
        Iso8601::parseDuration($isoString);
    }

    public function invalidIsoDurationStrings()
    {
        return array(
            // Duration Format - Empty/Zero
            'Missing P'                                 => array('',                        'Invalid ISO duration format: "".'),
            'Missing P has digit'                       => array('2',                       'Invalid ISO duration format: "2".'),
            'Missing P has digit designator'            => array('D',                       'Invalid ISO duration format: "D".'),
            'Missing P has digit and designator'        => array('2D',                      'Invalid ISO duration format: "2D".'),
            'Missing P has digit and designator dupe'   => array('2D2D',                    'Invalid ISO duration format: "2D2D".'),
            'Missing P has spaces'                      => array(' ',                       'Invalid ISO duration format: " ".'),
            'P with space prefix'                       => array(' P',                      'Invalid ISO duration format: " P".'),
            'P with space postfix'                      => array('P ',                      'Invalid ISO duration format: "P ".'),
            'P with space pre/post fix'                 => array(' P ',                     'Invalid ISO duration format: " P ".'),

            // Duration Format - Misc
            'Missing period designator'                 => array('P2',                      'Invalid ISO duration format: "P2".'),
            'Duplicate period designator'               => array('P2Y2Y',                   'Invalid ISO duration format: "P2Y2Y".'),
            'Missing T before hours designator'         => array('P2H',                     'Invalid ISO duration format: "P2H".'),
            'Missing T before seconds designator'       => array('P2S',                     'Invalid ISO duration format: "P2S".'),
            'Invalid negative period'                   => array('P-2Y',                    'Invalid ISO duration format: "P-2Y".'),

            // Date Time Format - Basic
            'Date time basic missing P'                 => array('00010203T040506',         'Invalid ISO duration format: "00010203T040506".'),
            'Date time basic missing T'                 => array('P00010203 040506',        'Invalid ISO duration format: "P00010203 040506".'),
            'Date time basic missing P and T'           => array('00010203 040506',         'Invalid ISO duration format: "00010203 040506".'),
            'Date time basic space prefix'              => array(' P00010203T040506',       'Invalid ISO duration format: " P00010203T040506".'),
            'Date time basic space postfix'             => array('P00010203T040506 ',       'Invalid ISO duration format: "P00010203T040506 ".'),
            'Date time basic space pre/post fix'        => array(' P00010203T040506 ',      'Invalid ISO duration format: " P00010203T040506 ".'),
            'Date time basic months exceeds moduli'     => array('P00001300T000000',        'Invalid ISO duration format: "P00001300T000000".'),
            'Date time basic days exceeds moduli'       => array('P00000032T000000',        'Invalid ISO duration format: "P00000032T000000".'),
            'Date time basic hours exceeds moduli'      => array('P00000000T250000',        'Invalid ISO duration format: "P00000000T250000".'),
            'Date time basic minutes exceeds moduli'    => array('P00000000T006000',        'Invalid ISO duration format: "P00000000T006000".'),
            'Date time basic seconds exceeds moduli'    => array('P00000000T000060',        'Invalid ISO duration format: "P00000000T000060".'),

            // Date Time Format - Extended
            'Date time extended missing P'              => array('0001-02-03T04:05:06',     'Invalid ISO duration format: "0001-02-03T04:05:06".'),
            'Date time extended missing T'              => array('P0001-02-03 04:05:06',    'Invalid ISO duration format: "P0001-02-03 04:05:06".'),
            'Date time extended missing P and T'        => array('0001-02-03 04:05:06',     'Invalid ISO duration format: "0001-02-03 04:05:06".'),
            'Date time extended space prefix'           => array(' P0001-02-03T04:05:06',   'Invalid ISO duration format: " P0001-02-03T04:05:06".'),
            'Date time extended space postfix'          => array('P0001-02-03T04:05:06 ',   'Invalid ISO duration format: "P0001-02-03T04:05:06 ".'),
            'Date time extended space pre/post fix'     => array(' P0001-02-03T04:05:06 ',  'Invalid ISO duration format: " P0001-02-03T04:05:06 ".'),
            'Date time extended months exceeds moduli'  => array('P0000-13-00T00:00:00',    'Invalid ISO duration format: "P0000-13-00T00:00:00".'),
            'Date time extended days exceeds moduli'    => array('P0000-00-32T00:00:00',    'Invalid ISO duration format: "P0000-00-32T00:00:00".'),
            'Date time extended hours exceeds moduli'   => array('P0000-00-00T25:00:00',    'Invalid ISO duration format: "P0000-00-00T25:00:00".'),
            'Date time extended minutes exceeds moduli' => array('P0000-00-00T00:60:00',    'Invalid ISO duration format: "P0000-00-00T00:60:00".'),
            'Date time extended seconds exceeds moduli' => array('P0000-00-00T00:00:60',    'Invalid ISO duration format: "P0000-00-00T00:00:60".'),
        );
    }
}
