<?php
namespace Icecave\Chrono\Support;

use Icecave\Chrono\TypeCheck\TypeCheck;

class Calendar
{
    /**
     * @param integer $year
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
        }

        if (self::isLeapYear($year)) {
            return 29;
        }

        return 28;
    }

    /**
     * @param integer $year
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
}
