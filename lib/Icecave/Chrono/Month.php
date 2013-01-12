<?php
namespace Icecave\Chrono;

class Month extends DateRangeAbstract
{
    protected function __construct($year, $month)
    {
        Detail\Normalizer::normalizeDate($year, $month);
        $this->year = new Year($year);
        $this->month = $month;
    }

    public function year()
    {
        return $this->year;
    }

    public function month()
    {
        return $this->month;
    }

    public function numberOfDays()
    {
        Detail\Calendar::daysInMonth($this->year()->year(), $this->month());
    }

    public function startDate()
    {
        return new Date(
            $this->year()->year(),
            $this->month(),
            1
        );
    }

    public function endDate()
    {
        return new Date(
            $this->year()->year(),
            $this->month(),
            $this->numberOfDays()
        );
    }

    public function compare(Month $month)
    {
        return $this->year() - $month->year()
            || $this->month() - $month->month();
    }

    private $year;
    private $month;
}
