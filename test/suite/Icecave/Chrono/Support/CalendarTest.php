<?php
namespace Icecave\Chrono\Support;

use PHPUnit_Framework_TestCase;

class CalendarTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider leapYearProvider
     */
    public function testDaysInYear($year, $isLeapYear)
    {
        if ($isLeapYear) {
            $this->assertSame(366, Calendar::daysInyear($year));
        } else {
            $this->assertSame(365, Calendar::daysInyear($year));
        }
    }

    /**
     * @dataProvider leapYearProvider
     */
    public function testIsLeapYear($year, $isLeapYear)
    {
        $this->assertSame($isLeapYear, Calendar::isLeapYear($year));
    }

    public function leapYearProvider()
    {
        return array(
            // Multiples of 4
            array(2001, false),
            array(2002, false),
            array(2003, false),
            array(2004, true),
            array(2005, false),
            array(2006, false),
            array(2007, false),
            array(2008, true),
            array(2009, false),
            array(2010, false),

            // With multiples of 100, only multiples of 400 are leap year ...
            array(2000, true),
            array(2100, false),
            array(2200, false),
            array(2300, false),
            array(2400, true),
            array(2500, false),
            array(2600, false),
            array(2700, false),
        );
    }

    /**
     * @dataProvider daysInMonthProvider
     */
    public function testDaysInMonth($year, $month, $daysInMonth)
    {
        $this->assertSame($daysInMonth, Calendar::daysInMonth($year, $month));
    }

    public function testDaysInMonthFailure()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid month: 0.');
        Calendar::daysInMonth(2012, 0);
    }

    public function daysInMonthProvider()
    {
        return array(
            'January'   => array(2005,  1, 31),
            'February'  => array(2005,  2, 28),
            'March'     => array(2005,  3, 31),
            'April'     => array(2005,  4, 30),
            'May'       => array(2005,  5, 31),
            'June'      => array(2005,  6, 30),
            'July'      => array(2005,  7, 31),
            'August'    => array(2005,  8, 31),
            'September' => array(2005,  9, 30),
            'October'   => array(2005, 10, 31),
            'November'  => array(2005, 11, 30),
            'December'  => array(2005, 12, 31),

            'January (Leap Year)'   => array(2008,  1, 31),
            'February (Leap Year)'  => array(2008,  2, 29),
            'March (Leap Year)'     => array(2008,  3, 31),
            'April (Leap Year)'     => array(2008,  4, 30),
            'May (Leap Year)'       => array(2008,  5, 31),
            'June (Leap Year)'      => array(2008,  6, 30),
            'July (Leap Year)'      => array(2008,  7, 31),
            'August (Leap Year)'    => array(2008,  8, 31),
            'September (Leap Year)' => array(2008,  9, 30),
            'October (Leap Year)'   => array(2008, 10, 31),
            'November (Leap Year)'  => array(2008, 11, 30),
            'December (Leap Year)'  => array(2008, 12, 31),
        );
    }

    /**
     * @dataProvider monthNames()
     */
    public function testMonthName($month, $expected)
    {
        $this->assertSame($expected, Calendar::monthName($month));
    }

    public function testMonthNameFailure()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid month: 0.');
        Calendar::monthName(0);
    }

    /**
     * @dataProvider monthNames()
     */
    public function testMonthAbbreviation($month, $expected)
    {
        $this->assertSame(substr($expected, 0, 3), Calendar::monthAbbreviation($month));
    }

    public function testMonthAbbreviationFailure()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid month: 0.');
        Calendar::monthAbbreviation(0);
    }

    public function monthNames()
    {
        return array(
            array(1,    'January'),
            array(2,    'February'),
            array(3,    'March'),
            array(4,    'April'),
            array(5,    'May'),
            array(6,    'June'),
            array(7,    'July'),
            array(8,    'August'),
            array(9,    'September'),
            array(10,   'October'),
            array(11,   'November'),
            array(12,   'December'),
        );
    }

    /**
     * @dataProvider dayNames()
     */
    public function testDayName($day, $expected)
    {
        $this->assertSame($expected, Calendar::dayName($day));
    }

    public function testDayNameFailure()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid ISO-8601 day of week: 0.');
        Calendar::dayName(0);
    }

    /**
     * @dataProvider dayNames()
     */
    public function testDayAbbreviation($day, $expected)
    {
        $this->assertSame(substr($expected, 0, 3), Calendar::dayAbbreviation($day));
    }

    public function testDayAbbreviationFailure()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid ISO-8601 day of week: 0.');
        Calendar::dayAbbreviation(0);
    }

    public function dayNames()
    {
        return array(
            array(1,    'Monday'),
            array(2,    'Tuesday'),
            array(3,    'Wednesday'),
            array(4,    'Thursday'),
            array(5,    'Friday'),
            array(6,    'Saturday'),
            array(7,    'Sunday'),
        );
    }

    public function testDayOfYear()
    {
        $this->assertSame(1, Calendar::dayOfYear(2011, 1, 1));
        $this->assertSame(165, Calendar::dayOfYear(2011, 6, 14));
        $this->assertSame(365, Calendar::dayOfYear(2011, 12, 31));

        $this->assertSame(1, Calendar::dayOfYear(2012, 1, 1));
        $this->assertSame(166, Calendar::dayOfYear(2012, 6, 14));
        $this->assertSame(366, Calendar::dayOfYear(2012, 12, 31));
    }

    public function testDayOfWeek()
    {
        $this->assertSame(1, Calendar::dayOfWeek(2012, 2, 27));
        $this->assertSame(2, Calendar::dayOfWeek(2012, 2, 28));
        $this->assertSame(3, Calendar::dayOfWeek(2012, 2, 29));
        $this->assertSame(4, Calendar::dayOfWeek(2012, 3, 1));
        $this->assertSame(5, Calendar::dayOfWeek(2012, 3, 2));
        $this->assertSame(6, Calendar::dayOfWeek(2012, 3, 3));
        $this->assertSame(7, Calendar::dayOfWeek(2012, 3, 4));

        $this->assertSame(1, Calendar::dayOfWeek(2012, 2, 27, false));
        $this->assertSame(2, Calendar::dayOfWeek(2012, 2, 28, false));
        $this->assertSame(3, Calendar::dayOfWeek(2012, 2, 29, false));
        $this->assertSame(4, Calendar::dayOfWeek(2012, 3, 1, false));
        $this->assertSame(5, Calendar::dayOfWeek(2012, 3, 2, false));
        $this->assertSame(6, Calendar::dayOfWeek(2012, 3, 3, false));
        $this->assertSame(0, Calendar::dayOfWeek(2012, 3, 4, false));
    }

    /**
     * @dataProvider isoWeekDates
     */
    public function testIsoWeekDate($year, $month, $day, $isoYear, $isoWeek, $isoDay)
    {
        $this->assertSame($isoWeek, Calendar::isoWeekNumber($year, $month, $day));
        $this->assertSame($isoYear, Calendar::isoYearNumber($year, $month, $day));
    }

    public function isoWeekDates()
    {
        return array(
            array(2005,  1,  1, 2004, 53, 6),
            array(2005,  1,  2, 2004, 53, 7),
            array(2005, 12, 31, 2005, 52, 6),
            array(2007,  1,  1, 2007,  1, 1), // Both years 2007 start with the same day.
            array(2007, 12, 30, 2007, 52, 7),
            array(2007, 12, 31, 2008,  1, 1),
            array(2008,  1,  1, 2008,  1, 2), // Gregorian year 2008 is a leap year, ISO year 2008 is 2 days shorter: 1 day longer at the start, 3 days shorter at the end.
            array(2008, 12, 28, 2008, 52, 7), // For 2008/2009 where the ISO week-numbering year is three days into the previous Gregorian year.
            array(2008, 12, 29, 2009,  1, 1),
            array(2008, 12, 30, 2009,  1, 2),
            array(2008, 12, 31, 2009,  1, 3),
            array(2009,  1,  1, 2009,  1, 4),
            array(2009, 12, 31, 2009, 53, 4), // ISO year 2009 has 53 weeks, extending the Gregorian year 2009, which starts and ends with Thursday, at both ends with three days. For 2009/2010 the ISO week-numbering year is three days into the next Gregorian year.
            array(2010,  1,  1, 2009, 53, 5),
            array(2010,  1,  2, 2009, 53, 6),
            array(2010,  1,  3, 2009, 53, 7),     
            array(2012,  1,  1, 2011, 52, 7),
        );
    }
}
