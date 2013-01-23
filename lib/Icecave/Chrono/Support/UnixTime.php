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

        $wholeDays = Calendar::dayOfYear($year, $month, $day) - 1;

        if ($year >= 1970) {
            for ($y = 1970; $y < $year; ++$y) {
                $wholeDays += Calendar::daysInYear($y);
            }
        } else {
            for ($y = 1969; $y >= $year; --$y) {
                $wholeDays -= Calendar::daysInYear($y);
            }
        }

        $timestamp  = $wholeDays * 86400;
        $timestamp += $hours * 3600;
        $timestamp += $minutes * 60;
        $timestamp += $seconds;

        return $timestamp;
    }
}
