<?php
namespace Icecave\Chrono;

class Year extends DateRangeAbstract
{
    public function __construct($year)
    {
        if ($year < 0 || $year > 9999) {
            throw new Exception\InvalidYearException($year);
        }

        $this->year = $year;
    }

    public function year()
    {
        return $this->year;
    }

    public function startDate()
    {
        return new Date($this->year(), 1, 1);
    }

    public function endDate()
    {
        return new Date($this->year(), 12, 31);
    }

    public function numberOfDays()
    {
        if ($this->isLeapYear()) {
            return 366;
        }
        return 365;
    }

    public function isLeapYear()
    {
        return Detail\Calendar::isLeapYear($this->year());
    }

    public function compare(Year $year)
    {
        return $this->year() - $year->year();
    }

    public function __toString()
    {
        return sprintf('%04d', $this->year());
    }

    private $year;
}
