<?php
namespace Icecave\Chrono;

/**
 * Represents a date.
 */
class Date
{
    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     */
    public function __construct($year, $month, $day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    private $year;
    private $month;
    private $day;
}
