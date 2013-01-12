<?php
namespace Icecave\Chrono;

use IteratorAggregate;

interface DateRangeInterface extends IteratorAggregate
{
    public function startDate();
    public function endDate();
    public function numberOfDays();

    public function containsDate(Date $date);
    public function containsDateTime(DateTime $dateTime);
    public function containsDateRange(DateRangeInterface $dateRange);
    public function intersectsDateRange(DateRangeInterface $dateRange);
}
