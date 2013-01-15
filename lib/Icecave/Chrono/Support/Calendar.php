<?php
namespace Icecave\Chrono\Support;

class Calendar
{
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
        }

        if (self::isLeapYear($year)) {
            return 29;
        }

        return 28;
    }

    public static function isLeapYear($year)
    {
        if ($year % 400 === 0) {
            return true;
        } elseif ($year % 100 === 0) {
            return false;
        }
        return $year % 4 === 0;
    }
}
