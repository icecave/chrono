<?php
namespace Icecave\Chrono\Support;

use Icecave\Chrono\TypeCheck\TypeCheck;

class UnixTime
{
    /**
     * @param integer       $year
     * @param integer       $month
     * @param integer       $day
     * @param integer       $hours
     * @param integer       $minutes
     * @param integer       $seconds
     */
    public static function makeTimestamp($year, $month, $day, $hours, $minutes, $seconds)
    {
        TypeCheck::get(__CLASS__)->makeTimestamp(func_get_args());

        Normalizer::normalizeTime($hours, $minutes, $seconds, $day);
        Normalizer::normalizeDate($year, $month, $day);

        $timestamp = 0;

        // Year ...
        if ($year >= 1970) {
            for ($y = 1970; $y < $year; ++$y) {
                $timestamp += Calendar::daysInYear($y) * 86400;
            }
        } else {
            for ($y = 1969; $y >= $year; --$y) {
                $timestamp -= Calendar::daysInYear($y) * 86400;
            }
        }

        // Month ...
        for ($m = 1; $m < $month; ++$m) {
            $timestamp += Calendar::daysInMonth($year, $m) * 86400;
        }

        // Days ...
        $timestamp += ($day - 1) * 86400;

        // Time ...
        $timestamp += $hours * 3600;
        $timestamp += $minutes * 60;
        $timestamp += $seconds;

        return $timestamp;
    }
}
