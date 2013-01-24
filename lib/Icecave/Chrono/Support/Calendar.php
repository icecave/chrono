<?php
namespace Icecave\Chrono\Support;

use Icecave\Chrono\TypeCheck\TypeCheck;
use InvalidArgumentException;

class Calendar
{
    /**
     * @param integer $year
     *
     * @return integer
     */
    public static function daysInYear($year)
    {
        TypeCheck::get(__CLASS__)->daysInYear(func_get_args());

        if (self::isLeapYear($year)) {
            return 366;
        }

        return 365;
    }

    /**
     * @param integer $year
     * @param integer $month
     *
     * @return integer
     */
    public static function daysInMonth($year, $month)
    {
        TypeCheck::get(__CLASS__)->daysInMonth(func_get_args());

        switch ($month) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                return 31;

            case 9:
            case 4:
            case 6:
            case 11:
                return 30;

            case 2:
                if (self::isLeapYear($year)) {
                    return 29;
                }

                return 28;
        }

        throw new InvalidArgumentException('Invalid month: ' . $month . '.');
    }

    /**
     * @param integer $year
     *
     * @return boolean
     */
    public static function isLeapYear($year)
    {
        TypeCheck::get(__CLASS__)->isLeapYear(func_get_args());

        if ($year % 400 === 0) {
            return true;
        } elseif ($year % 100 === 0) {
            return false;
        }

        return $year % 4 === 0;
    }

    /**
     * @param integer $month
     *
     * @return string
     */
    public static function monthName($month)
    {
        TypeCheck::get(__CLASS__)->monthName(func_get_args());

        switch ($month) {
            case 1:
                return 'January';
            case 2:
                return 'February';
            case 3:
                return 'March';
            case 4:
                return 'April';
            case 5:
                return 'May';
            case 6:
                return 'June';
            case 7:
                return 'July';
            case 8:
                return 'August';
            case 9:
                return 'September';
            case 10:
                return 'October';
            case 11:
                return 'November';
            case 12:
                return 'December';
        }

        throw new InvalidArgumentException('Invalid month: ' . $month . '.');
    }

    /**
     * @param integer $month
     *
     * @return string
     */
    public static function monthAbbreviation($month)
    {
        TypeCheck::get(__CLASS__)->monthAbbreviation(func_get_args());

        switch ($month) {
            case 1:
                return 'Jan';
            case 2:
                return 'Feb';
            case 3:
                return 'Mar';
            case 4:
                return 'Apr';
            case 5:
                return 'May';
            case 6:
                return 'Jun';
            case 7:
                return 'Jul';
            case 8:
                return 'Aug';
            case 9:
                return 'Sep';
            case 10:
                return 'Oct';
            case 11:
                return 'Nov';
            case 12:
                return 'Dec';
        }

        throw new InvalidArgumentException('Invalid month: ' . $month . '.');
    }

    /**
     * @param integer $isoDay
     *
     * @return string
     */
    public static function dayName($isoDay)
    {
        TypeCheck::get(__CLASS__)->dayName(func_get_args());

        switch ($isoDay) {
            case 1:
                return 'Monday';
            case 2:
                return 'Tuesday';
            case 3:
                return 'Wednesday';
            case 4:
                return 'Thursday';
            case 5:
                return 'Friday';
            case 6:
                return 'Saturday';
            case 7:
                return 'Sunday';
        }

        throw new InvalidArgumentException('Invalid ISO-8601 day of week: ' . $isoDay . '.');
    }

    /**
     * @param integer $isoDay
     *
     * @return string
     */
    public static function dayAbbreviation($isoDay)
    {
        TypeCheck::get(__CLASS__)->dayAbbreviation(func_get_args());

        switch ($isoDay) {
            case 1:
                return 'Mon';
            case 2:
                return 'Tue';
            case 3:
                return 'Wed';
            case 4:
                return 'Thu';
            case 5:
                return 'Fri';
            case 6:
                return 'Sat';
            case 7:
                return 'Sun';
        }

        throw new InvalidArgumentException('Invalid ISO-8601 day of week: ' . $isoDay . '.');
    }

    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     *
     * @return integer
     */
    public static function dayOfYear($year, $month, $day)
    {
        TypeCheck::get(__CLASS__)->dayOfYear(func_get_args());

        $day += self::$daysAtEndOfMonth[$month - 1];

        if (self::isLeapYear($year) && $month > 2) {
            ++$day;
        }

        return $day;
    }

    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param boolean $iso
     *
     * @return integer
     */
    public static function dayOfWeek($year, $month, $day, $iso = true)
    {
        TypeCheck::get(__CLASS__)->dayOfWeek(func_get_args());

        $m_table_common = array( -1, 0, 3, 3, 6, 1, 4, 6, 2, 5, 0, 3, 5 ); /* 1 = jan */
        $m_table_leap   = array( -1, 6, 2, 3, 6, 1, 4, 6, 2, 5, 0, 3, 5 ); /* 1 = jan */

        $centuryValue = function ($j) {
            $i = $j - 17;
            $c = (4 - $i * 2 + ($i + 1) / 4) % 7;

            return $c < 0 ? $c + 7 : $c;
        };

        $c1 = $centuryValue(intval($year / 100));
        $y1 = $year % 100;
        $m1 = self::isLeapYear($year) ? $m_table_leap[$month] : $m_table_common[$month];
        $dow = ($c1 + $y1 + $m1 + ($y1 / 4) + $day) % 7;
        if ($iso && $dow === 0) {
            $dow = 7;
        }

        return $dow;
    }

    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     *
     * @return integer
     */
    public static function isoWeekNumber($year, $month, $day)
    {
        TypeCheck::get(__CLASS__)->isoWeekNumber(func_get_args());

        list($year, $week) = self::isoWeekDate($year, $month, $day);

        return $week;
    }

    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     *
     * @return integer
     */
    public static function isoYearNumber($year, $month, $day)
    {
        TypeCheck::get(__CLASS__)->isoYearNumber(func_get_args());

        list($year, $week) = self::isoWeekDate($year, $month, $day);

        return $year;
    }

    /**
     * @param integer $y
     * @param integer $m
     * @param integer $d
     *
     * @return tuple<integer,integer,integer> Year, week, day of week.
     */
    private static function isoWeekDate($y, $m, $d)
    {
        TypeCheck::get(__CLASS__)->isoWeekDate(func_get_args());

        $iy = null;
        $iw = null;

        $y_leap = self::isLeapYear($y);
        $prev_y_leap = self::isLeapYear($y-1);
        $doy = self::dayOfYear($y, $m, $d);
        if ($y_leap && $m > 2) {
            $doy++;
        }
        $jan1weekday = self::dayOfWeek($y, 1, 1);
        $weekday = self::dayOfWeek($y, $m, $d);

        /* Find if Y M D falls in YearNumber Y-1, WeekNumber 52 or 53 */
        if ($doy <= (8 - $jan1weekday) && $jan1weekday > 4) {
            $iy = $y - 1;
            if ($jan1weekday == 5 || ($jan1weekday == 6 && $prev_y_leap)) {
                $iw = 53;
            } else {
                // NEVER GETS EXECUTED ?
                $iw = 52;
            }
        } else {
            $iy = $y;
        }

        /* 8. Find if Y M D falls in YearNumber Y+1, WeekNumber 1 */
        if ($iy == $y) {
            $i = $y_leap ? 366 : 365;
            if (($i - ($doy - $y_leap)) < (4 - $weekday)) {
                $iy = $y + 1;
                $iw = 1;

                return array($iy, $iw, $weekday);
            }
        }

        /* 9. Find if Y M D falls in YearNumber Y, WeekNumber 1 through 53 */
        if ($iy == $y) {
            $j = $doy + (7 - $weekday) + ($jan1weekday - 1);
            $iw = intval($j / 7);
            if ($jan1weekday > 4) {
                $iw -= 1;
            }
        }

        return array($iy, $iw, $weekday);
    }

    private static $daysAtEndOfMonth = array(
        0 => 0,
        1 => 31,
        2 => 59,
        3 => 90,
        4 => 120,
        5 => 151,
        6 => 181,
        7 => 212,
        8 => 243,
        9 => 273,
        10 => 304,
        11 => 334,
        12 => 365,
    );
}
