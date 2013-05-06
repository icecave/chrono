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

        $timestamp = gmmktime(
            0,
            0,
            0,
            $month,
            $day,
            $year
        );

        return 1 + gmdate('z', $timestamp);
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

        $timestamp = gmmktime(
            0,
            0,
            0,
            $month,
            $day,
            $year
        );

        if ($iso) {
            return intval(gmdate('N', $timestamp));
        }

        return intval(gmdate('w', $timestamp));
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

        $timestamp = gmmktime(
            0,
            0,
            0,
            $month,
            $day,
            $year
        );

        return intval(gmdate('W', $timestamp));
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

        $timestamp = gmmktime(
            0,
            0,
            0,
            $month,
            $day,
            $year
        );

        return intval(gmdate('o', $timestamp));
    }
}
