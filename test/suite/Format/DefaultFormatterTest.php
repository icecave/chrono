<?php

namespace Icecave\Chrono\Format;

use Eloquent\Liberator\Liberator;
use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeOfDay;
use Icecave\Chrono\TimeZone;
use PHPUnit\Framework\TestCase;

class DefaultFormatterTest extends TestCase
{
    public function setUp(): void
    {
        Liberator::liberateClass(__NAMESPACE__ . '\DefaultFormatter')->instance = null;

        $this->formatter    = new DefaultFormatter();
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
        $formats =  [
            'swatch internet time'  => ['B', '625'],

            'unpadded 12hr hours'   => ['g', '12'],
            'unpadded 24hr hours'   => ['G', '0'],
            'padded 12hr hours'     => ['h', '12'],
            'padded 24hr hours'     => ['H', '00'],
            'padded minutes'        => ['i', '00'],
            'padded seconds'        => ['s', '00'],

            'ISO-8601 date'         => ['c', '2012-06-07T00:00:00+10:00'],
            'RFC-2822 date'         => ['r', 'Thu, 07 Jun 2012 00:00:00 +1000'],
            'unix time'             => ['U', '1338991200'],
        ];

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
        return [
            'lowercase am/pm'       => ['a', 'am'], // need to test PM
            'uppercase am/pm'       => ['A', 'AM'],
            'swatch internet time'  => ['B', '005'],

            'unpadded 12hr hours'   => ['g', '9'], // need to test with PM
            'unpadded 24hr hours'   => ['G', '9'], // need to test with PM
            'padded 12hr hours'     => ['h', '09'], // need to test with PM
            'padded 24hr hours'     => ['H', '09'], // need to test with PM
            'padded minutes'        => ['i', '08'],
            'padded seconds'        => ['s', '07'],
            'microseconds'          => ['u', '0'],

            // 'timezone identifier'   => array('e', '???'), // not currently supported
            'daylight savings'      => ['I', '0'], // need to test DST
            'timezone offset'       => ['O', '+1000'], // need to test negative
            'timezone offset colon' => ['P', '+10:00'], // need to test negative
            // 'timezone abbreviation' => array('T', '???'), // not currently supported
            'timezone seconds'      => ['Z', '36000'], // need to test negative
        ];
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
        return [
            'padded day of month'   => ['d', '07'],
            'short day name'        => ['D', 'Thu'],
            'unpadded day of month' => ['j', '7'],
            'long day name'         => ['l', 'Thursday'],
            'ISO-8601 day number'   => ['N', '4'],
            'ordinal suffix'        => ['S', 'th'], // probably need to test other suffixes
            'day of week'           => ['w', '4'],
            'day of year'           => ['z', '159'],

            'ISO-8601 week number'  => ['W', '23'], // ??

            'long month name'       => ['F', 'June'],
            'padded month number'   => ['m', '06'],
            'short month name'      => ['M', 'Jun'],
            'unpadded month number' => ['n', '6'],
            'days in month'         => ['t', '30'],

            'leap year'             => ['L', '1'], // need to test non leap year
            'ISO-8601 year number'  => ['o', '2012'], // need to test wrapping based on week number
            'year number'           => ['Y', '2012'],
            'short year number'     => ['y', '12'],

            'lowercase am/pm'       => ['a', 'am'], // need to test PM
            'uppercase am/pm'       => ['A', 'AM'],
            'swatch internet time'  => ['B', '005'],

            'unpadded 12hr hours'   => ['g', '9'], // need to test with PM
            'unpadded 24hr hours'   => ['G', '9'], // need to test with PM
            'padded 12hr hours'     => ['h', '09'], // need to test with PM
            'padded 24hr hours'     => ['H', '09'], // need to test with PM
            'padded minutes'        => ['i', '08'],
            'padded seconds'        => ['s', '07'],
            'microseconds'          => ['u', '0'],

            // 'timezone identifier'   => array('e', '???'), // not currently supported
            'daylight savings'      => ['I', '0'], // need to test DST
            'timezone offset'       => ['O', '+1000'], // need to test negative
            'timezone offset colon' => ['P', '+10:00'], // need to test negative
            // 'timezone abbreviation' => array('T', '???'), // not currently supported
            'timezone seconds'      => ['Z', '36000'], // need to test negative

            'ISO-8601 date'         => ['c', '2012-06-07T09:08:07+10:00'],
            'RFC-2822 date'         => ['r', 'Thu, 07 Jun 2012 09:08:07 +1000'],
            'unix time'             => ['U', '1339024087'],
        ];
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
        return [
            // 'timezone identifier'   => array('e', '???'), // not currently supported
            'daylight savings'      => ['I', '1'], // need to test DST
            'timezone offset'       => ['O', '+0930'], // need to test negative
            'timezone offset colon' => ['P', '+09:30'], // need to test negative
            // 'timezone abbreviation' => array('T', '???'), // not currently supported
            'timezone seconds'      => ['Z', '34200'], // need to test negative
        ];
    }

    public function testInstance()
    {
        $a = DefaultFormatter::instance();
        $b = DefaultFormatter::instance();

        $this->assertInstanceOf(__NAMESPACE__ . '\DefaultFormatter', $a);
        $this->assertSame($a, $b);
    }
}
