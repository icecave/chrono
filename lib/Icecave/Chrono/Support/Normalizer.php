<?php
namespace Icecave\Chrono\Support;

class Normalizer
{
    public static function normalizeTime(&$hours, &$minutes, &$seconds, &$days = 0)
    {
        $minutes += self::normalizeOverflow($seconds, 0, 60);
        $hours   += self::normalizeOverflow($minutes, 0, 60);
        $days    += self::normalizeOverflow($hours,   0, 24);
    }

    public static function normalizeDate(&$year, &$month, &$day = 1)
    {
        $year += self::normalizeOverflow($month, 1, 12);

        if ($day < 1) {
            while ($day < 1) {
                --$month;
                $year += self::normalizeOverflow($month, 1, 12);
                $daysInMonth = Calendar::daysInMonth($year, $month);
                $day += $daysInMonth;
            }
        } else {
            $daysInMonth = Calendar::daysInMonth($year, $month);
            while ($day > $daysInMonth) {
                ++$month;
                $day -= $daysInMonth;
                $year += self::normalizeOverflow($month, 1, 12);
                $daysInMonth = Calendar::daysInMonth($year, $month);
            }
        }
    }

    private static function normalizeOverflow(&$value, $min, $max)
    {
        if ($value < $min) {
            $overflow = intval($value / $max) - 1;
        } elseif ($value > $max) {
            $overflow = intval($value / $max);
        } else {
            $overflow = 0;
        }
        $value -= $overflow * $max;

        return $overflow;
    }
}
