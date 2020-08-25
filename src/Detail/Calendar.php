<?php

namespace Icecave\Chrono\Detail;

use InvalidArgumentException;

abstract class Calendar
{
    /**
     * @param int $year
     *
     * @return int
     */
    public static function daysInYear($year)
    {
        if (self::isLeapYear($year)) {
            return 366;
        }

        return 365;
    }

    /**
     * @param int $year
     * @param int $month
     *
     * @return int
     */
    public static function daysInMonth($year, $month)
    {
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
     * @param int $year
     *
     * @return bool
     */
    public static function isLeapYear($year)
    {
        if ($year % 400 === 0) {
            return true;
        } elseif ($year % 100 === 0) {
            return false;
        }

        return $year % 4 === 0;
    }

    /**
     * @param int $month
     *
     * @return string
     */
    public static function monthName($month)
    {
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
     * @param int $month
     *
     * @return string
     */
    public static function monthAbbreviation($month)
    {
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
     * @param int $isoDay
     *
     * @return string
     */
    public static function dayName($isoDay)
    {
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
     * @param int $isoDay
     *
     * @return string
     */
    public static function dayAbbreviation($isoDay)
    {
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
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return int
     */
    public static function dayOfYear($year, $month, $day)
    {
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
     * @param int  $year
     * @param int  $month
     * @param int  $day
     * @param bool $iso
     *
     * @return int
     */
    public static function dayOfWeek($year, $month, $day, $iso = true)
    {
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
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return int
     */
    public static function isoWeekNumber($year, $month, $day)
    {
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
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return int
     */
    public static function isoYearNumber($year, $month, $day)
    {
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

    /**
     * @param int $years   The years in the period.
     * @param int $months  The months in the period.
     * @param int $weeks   The weeks in the period.
     * @param int $days    The days in the period.
     * @param int $hours   The hours in the period.
     * @param int $minutes The minutes in the period.
     * @param int $seconds The seconds in the period.
     *
     * @return int The approximate total seconds in the period.
     */
    public static function approximateTotalSeconds($years = 0, $months = 0, $weeks = 0, $days = 0, $hours = 0, $minutes = 0, $seconds = 0)
    {
        $days += $weeks * 7;

        $seconds  = $seconds;
        $seconds += $minutes * 60;
        $seconds += $hours * 3600;

        // avg days in year = 365.25
        // average seconds in year = 365.25 * 86,400 = 31,557,600
        // average seconds in month = 31,557,600 / 12 = 2,629,800
        $seconds += $days * 86400;
        $seconds += $months * 2629800;
        $seconds += $years * 31557600;

        return $seconds;
    }
}
