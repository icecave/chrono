<?php

namespace Icecave\Chrono\Detail;

use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
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
        return [
            // Multiples of 4
            [2001, false],
            [2002, false],
            [2003, false],
            [2004, true],
            [2005, false],
            [2006, false],
            [2007, false],
            [2008, true],
            [2009, false],
            [2010, false],

            // With multiples of 100, only multiples of 400 are leap year ...
            [2000, true],
            [2100, false],
            [2200, false],
            [2300, false],
            [2400, true],
            [2500, false],
            [2600, false],
            [2700, false],
        ];
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
        $this->expectException('InvalidArgumentException', 'Invalid month: 0.');
        Calendar::daysInMonth(2012, 0);
    }

    public function daysInMonthProvider()
    {
        return [
            'January'   => [2005,  1, 31],
            'February'  => [2005,  2, 28],
            'March'     => [2005,  3, 31],
            'April'     => [2005,  4, 30],
            'May'       => [2005,  5, 31],
            'June'      => [2005,  6, 30],
            'July'      => [2005,  7, 31],
            'August'    => [2005,  8, 31],
            'September' => [2005,  9, 30],
            'October'   => [2005, 10, 31],
            'November'  => [2005, 11, 30],
            'December'  => [2005, 12, 31],

            'January (Leap Year)'   => [2008,  1, 31],
            'February (Leap Year)'  => [2008,  2, 29],
            'March (Leap Year)'     => [2008,  3, 31],
            'April (Leap Year)'     => [2008,  4, 30],
            'May (Leap Year)'       => [2008,  5, 31],
            'June (Leap Year)'      => [2008,  6, 30],
            'July (Leap Year)'      => [2008,  7, 31],
            'August (Leap Year)'    => [2008,  8, 31],
            'September (Leap Year)' => [2008,  9, 30],
            'October (Leap Year)'   => [2008, 10, 31],
            'November (Leap Year)'  => [2008, 11, 30],
            'December (Leap Year)'  => [2008, 12, 31],
        ];
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
        $this->expectException('InvalidArgumentException', 'Invalid month: 0.');
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
        $this->expectException('InvalidArgumentException', 'Invalid month: 0.');
        Calendar::monthAbbreviation(0);
    }

    public function monthNames()
    {
        return [
            [1,    'January'],
            [2,    'February'],
            [3,    'March'],
            [4,    'April'],
            [5,    'May'],
            [6,    'June'],
            [7,    'July'],
            [8,    'August'],
            [9,    'September'],
            [10,   'October'],
            [11,   'November'],
            [12,   'December'],
        ];
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
        $this->expectException('InvalidArgumentException', 'Invalid ISO-8601 day of week: 0.');
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
        $this->expectException('InvalidArgumentException', 'Invalid ISO-8601 day of week: 0.');
        Calendar::dayAbbreviation(0);
    }

    public function dayNames()
    {
        return [
            [1,    'Monday'],
            [2,    'Tuesday'],
            [3,    'Wednesday'],
            [4,    'Thursday'],
            [5,    'Friday'],
            [6,    'Saturday'],
            [7,    'Sunday'],
        ];
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
        return [
            [2005,  1,  1, 2004, 53, 6],
            [2005,  1,  2, 2004, 53, 7],
            [2005, 12, 31, 2005, 52, 6],
            [2007,  1,  1, 2007,  1, 1], // Both years 2007 start with the same day.
            [2007, 12, 30, 2007, 52, 7],
            [2007, 12, 31, 2008,  1, 1],
            [2008,  1,  1, 2008,  1, 2], // Gregorian year 2008 is a leap year, ISO year 2008 is 2 days shorter: 1 day longer at the start, 3 days shorter at the end.
            [2008, 12, 28, 2008, 52, 7], // For 2008/2009 where the ISO week-numbering year is three days into the previous Gregorian year.
            [2008, 12, 29, 2009,  1, 1],
            [2008, 12, 30, 2009,  1, 2],
            [2008, 12, 31, 2009,  1, 3],
            [2009,  1,  1, 2009,  1, 4],
            [2009, 12, 31, 2009, 53, 4], // ISO year 2009 has 53 weeks, extending the Gregorian year 2009, which starts and ends with Thursday, at both ends with three days. For 2009/2010 the ISO week-numbering year is three days into the next Gregorian year.
            [2010,  1,  1, 2009, 53, 5],
            [2010,  1,  2, 2009, 53, 6],
            [2010,  1,  3, 2009, 53, 7],
            [2012,  1,  1, 2011, 52, 7],
        ];
    }

    public function testApproximateTotalSeconds()
    {
        $this->assertSame(0, Calendar::approximateTotalSeconds());
        $this->assertSame(38995567, Calendar::approximateTotalSeconds(1, 2, 3, 4, 5, 6, 7));

        $this->assertSame(60, Calendar::approximateTotalSeconds(0, 0, 0, 0, 0, 0, 60));
        $this->assertSame(60, Calendar::approximateTotalSeconds(0, 0, 0, 0, 0, 1));

        $this->assertSame(3600, Calendar::approximateTotalSeconds(0, 0, 0, 0, 0, 60));
        $this->assertSame(3600, Calendar::approximateTotalSeconds(0, 0, 0, 0, 1));

        $this->assertSame(86400, Calendar::approximateTotalSeconds(0, 0, 0, 0, 24));
        $this->assertSame(86400, Calendar::approximateTotalSeconds(0, 0, 0, 1));

        $this->assertSame(604800, Calendar::approximateTotalSeconds(0, 0, 0, 7));
        $this->assertSame(604800, Calendar::approximateTotalSeconds(0, 0, 1));

        $this->assertSame(2629800, Calendar::approximateTotalSeconds(0, 1));
        $this->assertSame(31557600, Calendar::approximateTotalSeconds(1));
    }
}
