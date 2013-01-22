<?php
namespace Icecave\Chrono\Support;

use Icecave\Chrono\TypeCheck\TypeCheck;

class Normalizer
{
    /**
     * @param integer &$hours
     * @param integer &$minutes
     * @param integer &$seconds
     * @param integer &$days
     */
    public static function normalizeTime(&$hours, &$minutes, &$seconds, &$days = 0)
    {
        TypeCheck::get(__CLASS__)->normalizeTime(func_get_args());

        $minutes += self::normalizeOverflow($seconds, 0, 60);
        $hours   += self::normalizeOverflow($minutes, 0, 60);
        $days    += self::normalizeOverflow($hours,   0, 24);
    }

    /**
     * @param integer &$year
     * @param integer &$month
     * @param integer &$day
     */
    public static function normalizeDate(&$year, &$month, &$day = 1)
    {
        TypeCheck::get(__CLASS__)->normalizeDate(func_get_args());

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

    /**
     * @param integer &$value
     * @param integer $min
     * @param integer $max
     */
    private static function normalizeOverflow(&$value, $min, $max)
    {
        TypeCheck::get(__CLASS__)->normalizeOverflow(func_get_args());

        if ($value < $min) {
            $overflow = 0;
            while ($value < $min) {
                --$overflow;
                $value += $max;
            }
        } elseif ($value > $max) {
            $overflow = intval($value / $max);
            $value -= $overflow * $max;
        } else {
            $overflow = 0;
        }

        return $overflow;
    }
}
