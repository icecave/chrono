<?php
namespace Icecave\Chrono\Support;

use Icecave\Chrono\TypeCheck\TypeCheck;

class UnixTime
{
    /**
     * Provides a native PHP implementation of gmmktime.
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param integer $hours
     * @param integer $minutes
     * @param integer $seconds
     *
     * @return integer
     */
    public static function makeTimestamp($year, $month, $day, $hours, $minutes, $seconds)
    {
        TypeCheck::get(__CLASS__)->makeTimestamp(func_get_args());

        Normalizer::normalizeTime($hours, $minutes, $seconds, $day);
        Normalizer::normalizeDate($year, $month, $day);

        $wholeDays  = 0;

        if ($year >= 1970) {
            for ($y = 1970; $y < $year; ++$y) {
                $wholeDays += Calendar::daysInYear($y);
            }
        } else {
            for ($y = 1969; $y >= $year; --$y) {
                $wholeDays -= Calendar::daysInYear($y);
            }
        }

        $wholeDays += self::$daysAtEndOfMonth[$month - 1];
        $wholeDays += $day - 1;

        if (Calendar::isLeapYear($year) && $month > 2) {
            ++$wholeDays;
        }

        $timestamp  = $wholeDays * 86400;
        $timestamp += $hours * 3600;
        $timestamp += $minutes * 60;
        $timestamp += $seconds;

        return $timestamp;
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
