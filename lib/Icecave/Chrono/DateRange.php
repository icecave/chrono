<?php
namespace Icecave\Chrono;

class DateRange extends DateRangeAbstract
{
    public function __construct(Date $startDate, Date $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function startDate()
    {
        return $this->startDate;
    }

    public function endDate()
    {
        return $this->endDate;
    }

    public function numberOfDays()
    {
        throw new \LogicError('Not implemented!');
    }

    private $endDate;
    private $startDate;
}
