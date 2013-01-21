<?php
namespace Icecave\Chrono\Support;

use PHPUnit_Framework_TestCase;

class CalendarTest extends PHPUnit_Framework_TestCase
{
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
}
