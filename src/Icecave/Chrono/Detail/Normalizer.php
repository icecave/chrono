<?php
namespace Icecave\Chrono\Detail;

use Icecave\Chrono\TypeCheck\TypeCheck;

abstract class Normalizer
{
    /**
     * @param integer &$hour
     * @param integer &$minute
     * @param integer &$second
     * @param integer &$day
     */
    public static function normalizeTime(&$hour, &$minute, &$second, &$day = 0)
    {
        TypeCheck::get(__CLASS__)->normalizeTime(func_get_args());

        $minute += self::normalizeOverflow($second, 0, 60);
        $hour   += self::normalizeOverflow($minute, 0, 60);
        $day    += self::normalizeOverflow($hour,   0, 24);
    }

    /**
     * @param integer &$year
     * @param integer &$month
     * @param integer &$day
     */
    public static function normalizeDate(&$year, &$month, &$day = 1)
    {
        TypeCheck::get(__CLASS__)->normalizeDate(func_get_args());

        $year += self::normalizeOverflow($month, 1, 13);

        if ($day < 1) {
            while ($day < 1) {
                --$month;
                $year += self::normalizeOverflow($month, 1, 13);
                $daysInMonth = Calendar::daysInMonth($year, $month);
                $day += $daysInMonth;
            }
        } else {
            $daysInMonth = Calendar::daysInMonth($year, $month);
            while ($day > $daysInMonth) {
                ++$month;
                $day -= $daysInMonth;
                $year += self::normalizeOverflow($month, 1, 13);
                $daysInMonth = Calendar::daysInMonth($year, $month);
            }
        }
    }

    /**
     * @param integer &$value
     * @param integer $min
     * @param integer $max
     *
     * @return integer The normalized value.
     */
    private static function normalizeOverflow(&$value, $min, $max)
    {
        TypeCheck::get(__CLASS__)->normalizeOverflow(func_get_args());

        $range = $max - $min;

        if ($value < $min) {
            $overflow = 0;
            while ($value < $min) {
                --$overflow;
                $value += $range;
            }
        } elseif ($value >= $max) {
            $overflow = intval($value / $range);
            $value -= $overflow * $range;
        } else {
            $overflow = 0;
        }

        return $overflow;
    }
}