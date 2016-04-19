<?php

namespace Icecave\Chrono\Detail;

abstract class Ordinal
{
    /**
     * @param integer $number
     *
     * @return string
     */
    public static function suffix($number)
    {
        $mod100 = $number % 100;

        if ($mod100 < 11 || $mod100 > 13) {
            switch ($number % 10) {
                case 1:
                    return 'st';
                case 2:
                    return 'nd';
                case 3:
                    return 'rd';
                default:
                    // fall-through ...
            }
        }

        return 'th';
    }
}
