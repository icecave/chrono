<?php
namespace Icecave\Chrono\Format;

use Eloquent\Liberator\Liberator;
use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeOfDay;
use Icecave\Chrono\TimeZone;
use PHPUnit_Framework_TestCase;

class DefaultFormatterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Liberator::liberateClass(__NAMESPACE__ . '\DefaultFormatter')->instance = null;

        $this->formatter = new DefaultFormatter;
        $this->specialChars = 'dDjlNSwzWFmMntLoYyaABgGhHisueIOPTZcrU';
        $this->escapedChars = '\\d\\D\\j\\l\\N\\S\\w\\z\\W\\F\\m\\M\\n\\t\\L\\o\\Y\\y\\a\\A\\B\\g\\G\\h\\H\\i\\s\\u\\e\\I\\O\\P\\T\\Z\\c\\r\\U';

        $this->timeZone = new TimeZone(36000);
        $this->date     = new Date(2012, 6, 7, $this->timeZone);
        $this->time     = new TimeOfDay(9, 8, 7, $this->timeZone);
        $this->dateTime = new DateTime(2012, 6, 7, 9, 8, 7, $this->timeZone);
    }

    public function testEscape()
    {
        // Escape special characters ...
        $this->assertSame($this->escapedChars, $this->formatter->escape($this->specialChars));

        // Don't escape already escaped characters ...
        $this->assertSame($this->escapedChars, $this->formatter->escape($this->escapedChars));
    }

    public function testEscapingIsHonoured()
    {
        $this->assertSame($this->specialChars, $this->formatter->formatDate($this->date, $this->escapedChars));
        // do timeOfDay
        $this->assertSame($this->specialChars, $this->formatter->formatDateTime($this->dateTime, $this->escapedChars));
        // do timeZone
    }

    public function testEscapingOfNonSpecialCharacters()
    {
        $this->assertSame('X', $this->formatter->formatDate($this->date, '\X'));
        // do timeOfDay
        $this->assertSame('X', $this->formatter->formatDateTime($this->dateTime, '\X'));
        // do timeZone
    }

    public function testEscapingOfBackslash()
    {
        $this->assertSame('\X', $this->formatter->formatDate($this->date, '\\\\X'));
        // do timeOfDay
        $this->assertSame('\X', $this->formatter->formatDateTime($this->dateTime, '\\\\X'));
        // do timeZone
    }

    public function testEscapingBackslashAtEnd()
    {
        $this->assertSame('X\\', $this->formatter->formatDate($this->date, 'X\\'));
        // do timeOfDay
        $this->assertSame('X\\', $this->formatter->formatDateTime($this->dateTime, 'X\\'));
        // do timeZone
    }

    /**
     * @dataProvider dateFormats
     */
    public function testFormatDate($formatSpecifier, $expected)
    {
        $this->assertSame($expected, $this->formatter->formatDate($this->date, $formatSpecifier));
    }

    public function dateFormats()
    {
        $formats =  array(
            'swatch internet time'  => array('B', '625'),

            'unpadded 12hr hours'   => array('g', '12'),
            'unpadded 24hr hours'   => array('G', '0'),
            'padded 12hr hours'     => array('h', '12'),
            'padded 24hr hours'     => array('H', '00'),
            'padded minutes'        => array('i', '00'),
            'padded seconds'        => array('s', '00'),

            'ISO-8601 date'         => array('c', '2012-06-07T00:00:00+10:00'),
            'RFC-2822 date'         => array('r', 'Thu, 07 Jun 2012 00:00:00 +1000'),
            'unix time'             => array('U', '1338991200'),
        );

        return $formats + $this->dateTimeFormats();
    }

    /**
     * @dataProvider timeOfDayFormats
     */
    public function testFormatTimeOfDay($formatSpecifier, $expected)
    {
        $this->assertSame($expected, $this->formatter->formatTimeOfDay($this->time, $formatSpecifier));
    }

    public function timeOfDayFormats()
    {
        return array(
            'lowercase am/pm'       => array('a', 'am'), // need to test PM
            'uppercase am/pm'       => array('A', 'AM'),
            'swatch internet time'  => array('B', '005'),

            'unpadded 12hr hours'   => array('g', '9'), // need to test with PM
            'unpadded 24hr hours'   => array('G', '9'), // need to test with PM
            'padded 12hr hours'     => array('h', '09'), // need to test with PM
            'padded 24hr hours'     => array('H', '09'), // need to test with PM
            'padded minutes'        => array('i', '08'),
            'padded seconds'        => array('s', '07'),
            'microseconds'          => array('u', '0'),

            // 'timezone identifier'   => array('e', '???'), // not currently supported
            'daylight savings'      => array('I', '0'), // need to test DST
            'timezone offset'       => array('O', '+1000'), // need to test negative
            'timezone offset colon' => array('P', '+10:00'), // need to test negative
            // 'timezone abbreviation' => array('T', '???'), // not currently supported
            'timezone seconds'      => array('Z', '36000'), // need to test negative
        );
    }

    /**
     * @dataProvider dateTimeFormats
     */
    public function testFormatDateTime($formatSpecifier, $expected)
    {
        $this->assertSame($expected, $this->formatter->formatDateTime($this->dateTime, $formatSpecifier));
    }

    public function dateTimeFormats()
    {
        return array(
            'padded day of month'   => array('d', '07'),
            'short day name'        => array('D', 'Thu'),
            'unpadded day of month' => array('j', '7'),
            'long day name'         => array('l', 'Thursday'),
            'ISO-8601 day number'   => array('N', '4'),
            'ordinal suffix'        => array('S', 'th'), // probably need to test other suffixes
            'day of week'           => array('w', '4'),
            'day of year'           => array('z', '159'),

            'ISO-8601 week number'  => array('W', '23'), // ??

            'long month name'       => array('F', 'June'),
            'padded month number'   => array('m', '06'),
            'short month name'      => array('M', 'Jun'),
            'unpadded month number' => array('n', '6'),
            'days in month'         => array('t', '30'),

            'leap year'             => array('L', '1'), // need to test non leap year
            'ISO-8601 year number'  => array('o', '2012'), // need to test wrapping based on week number
            'year number'           => array('Y', '2012'),
            'short year number'     => array('y', '12'),

            'lowercase am/pm'       => array('a', 'am'), // need to test PM
            'uppercase am/pm'       => array('A', 'AM'),
            'swatch internet time'  => array('B', '005'),

            'unpadded 12hr hours'   => array('g', '9'), // need to test with PM
            'unpadded 24hr hours'   => array('G', '9'), // need to test with PM
            'padded 12hr hours'     => array('h', '09'), // need to test with PM
            'padded 24hr hours'     => array('H', '09'), // need to test with PM
            'padded minutes'        => array('i', '08'),
            'padded seconds'        => array('s', '07'),
            'microseconds'          => array('u', '0'),

            // 'timezone identifier'   => array('e', '???'), // not currently supported
            'daylight savings'      => array('I', '0'), // need to test DST
            'timezone offset'       => array('O', '+1000'), // need to test negative
            'timezone offset colon' => array('P', '+10:00'), // need to test negative
            // 'timezone abbreviation' => array('T', '???'), // not currently supported
            'timezone seconds'      => array('Z', '36000'), // need to test negative

            'ISO-8601 date'         => array('c', '2012-06-07T09:08:07+10:00'),
            'RFC-2822 date'         => array('r', 'Thu, 07 Jun 2012 09:08:07 +1000'),
            'unix time'             => array('U', '1339024087'),
        );
    }

    /**
     * @dataProvider timeZoneFormats
     */
    public function testFormatTimeZone($formatSpecifier, $expected)
    {
        $timeZone = new TimeZone(34200, true);
        $this->assertSame($expected, $this->formatter->formatTimeZone($timeZone, $formatSpecifier));
    }

    public function timeZoneFormats()
    {
        return array(
            // 'timezone identifier'   => array('e', '???'), // not currently supported
            'daylight savings'      => array('I', '1'), // need to test DST
            'timezone offset'       => array('O', '+0930'), // need to test negative
            'timezone offset colon' => array('P', '+09:30'), // need to test negative
            // 'timezone abbreviation' => array('T', '???'), // not currently supported
            'timezone seconds'      => array('Z', '34200'), // need to test negative
        );
    }

    public function testInstance()
    {
        $a = DefaultFormatter::instance();
        $b = DefaultFormatter::instance();

        $this->assertInstanceOf(__NAMESPACE__ . '\DefaultFormatter', $a);
        $this->assertSame($a, $b);
    }
}
