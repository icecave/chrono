<?php
namespace Icecave\Chrono;

class Date
{
    public function __construct($year, $month, $day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    public function year()
    {
        return $this->year;
    }

    public function month()
    {
        return $this->month;
    }

    public function day()
    {
        return $this->day;
    }

    public function yearRange()
    {
        return new Year($this->year());
    }

    public function monthRange()
    {
        return new Month($this->year(), $this->month());
    }

    public function compare(Date $date)
    {
        return $this->year() - $date->year()
            || $this->month() - $date->month()
            || $this->day() - $date->day();
    }

    public function at(Time $time)
    {
        return new DateTime(
            $this->year(),
            $this->month(),
            $this->day(),
            $time->hours(),
            $time->minutes(),
            $time->seconds(),
            $time->timeZone()
        );
    }

    public function __toString()
    {
        return sprintf(
            '%04d-%02d-%02d',
            $this->year(),
            $this->month(),
            $this->day()
        );
    }

    private $year;
    private $month;
    private $day;
}
