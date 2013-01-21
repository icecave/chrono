<?php
namespace Icecave\Chrono;

/**
 * Represents a date/time.
 */
class DateTime
{
    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param integer $hours
     * @param integer $minutes
     * @param integer $seconds
     * @param TimeZone|null $timeZone
     */
    public function __construct(
        $year,
        $month,
        $day,
        $hours = 0,
        $minutes = 0,
        $seconds = 0,
        TimeZone $timeZone = null
    ) {
        if ($timeZone === null) {
            $timeZone = new TimeZone;
        }

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
        $this->timeZone = $timeZone;
    }

    private $year;
    private $month;
    private $day;
    private $hours;
    private $minutes;
    private $seconds;
    private $timeZone;
}
