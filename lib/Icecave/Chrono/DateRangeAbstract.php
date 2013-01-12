<?php
namespace Icecave\Chrono;

abstract class DateRangeAbstract implements DateRangeInterface
{
    public function containsDate(Date $date)
    {
        return $this->startDate()->compare($date) <= 0
            && $this->endDate()->compare($date) >= 0;
    }

    public function containsDateTime(DateTime $dateTime)
    {
        return $this->startDate()->at(0, 0, 0)->compare($dateTime) <= 0
            && $this->endDate()->at(23, 59, 59)->compare($dateTime) >= 0;
    }

    public function containsDateRange(DateRangeInterface $dateRange)
    {
        return $this->startDate()->compare($dateRange->startDate()) <= 0
            && $this->endDate()->compare($dateRange->endDate()) >= 0;
    }

    public function intersectsDateRange(DateRangeInterface $dateRange)
    {
        return $this->startDate()->compare($dateRange->endDate()) <= 0
            && $this->endDate()->compare($dateRange->startDate()) >= 0;
    }

    public function getIterator()
    {
        return new DateIterator($this->startDate(), $this->endDate());
    }
}
