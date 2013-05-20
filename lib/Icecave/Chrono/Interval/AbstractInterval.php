<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Iterator\DayIntervalIterator;
use Icecave\Chrono\Iterator\HourIntervalIterator;
use Icecave\Chrono\Iterator\MinuteIntervalIterator;
use Icecave\Chrono\Iterator\MonthIntervalIterator;
use Icecave\Chrono\Iterator\SecondIntervalIterator;
use Icecave\Chrono\Iterator\YearIntervalIterator;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\Duration;
use Icecave\Chrono\TypeCheck\TypeCheck;

abstract class AbstractInterval implements IntervalInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * @return boolean True if the interval indicates a non-zero duration; otherwise, false.
     */
    public function isEmpty()
    {
        $this->typeCheck->isEmpty(func_get_args());

        return $this->start()->isEqualTo($this->end());
    }

    /**
     * Perform a {@see strcmp} style comparison with another interval.
     *
     * @param IntervalInterface $interval The interval to compare.
     *
     * @return integer 0 if $this and $interval are equal, <0 if $this < $interval, or >0 if $this > $interval.
     */
    public function compare(IntervalInterface $interval)
    {
        $this->typeCheck->compare(func_get_args());

        return $this->start()->compare($interval->start())
            ?: $this->end()->compare($interval->end());
    }

    /**
     * @param IntervalInterface $interval The interval to compare.
     *
     * @return boolean True if $this and $interval are equal.
     */
    public function isEqualTo(IntervalInterface $interval)
    {
        $this->typeCheck->isEqualTo(func_get_args());

        return $this->compare($interval) === 0;
    }

    /**
     * @param IntervalInterface $interval The interval to compare.
     *
     * @return boolean True if $this and $interval are not equal.
     */
    public function isNotEqualTo(IntervalInterface $interval)
    {
        $this->typeCheck->isNotEqualTo(func_get_args());

        return $this->compare($interval) !== 0;
    }

    /**
     * @param IntervalInterface $interval The interval to compare.
     *
     * @return boolean True if $this > $interval.
     */
    public function isGreaterThan(IntervalInterface $interval)
    {
        $this->typeCheck->isGreaterThan(func_get_args());

        return $this->compare($interval) > 0;
    }

    /**
     * @param IntervalInterface $interval The interval to compare.
     *
     * @return boolean True if $this < $interval.
     */
    public function isLessThan(IntervalInterface $interval)
    {
        $this->typeCheck->isLessThan(func_get_args());

        return $this->compare($interval) < 0;
    }

    /**
     * @param IntervalInterface $interval The interval to compare.
     *
     * @return boolean True if $this >= $interval.
     */
    public function isGreaterThanOrEqualTo(IntervalInterface $interval)
    {
        $this->typeCheck->isGreaterThanOrEqualTo(func_get_args());

        return $this->compare($interval) >= 0;
    }

    /**
     * @param IntervalInterface $interval The interval to compare.
     *
     * @return boolean True if $this <= $interval.
     */
    public function isLessThanOrEqualTo(IntervalInterface $interval)
    {
        $this->typeCheck->isLessThanOrEqualTo(func_get_args());

        return $this->compare($interval) <= 0;
    }

    /**
     * Check if a given time point is contained within this interval.
     *
     * @param TimePointInterface $timePoint The time point to check.
     *
     * @return boolean True if this interval contains the given time point; otherwise, false.
     */
    public function contains(TimePointInterface $timePoint)
    {
        $this->typeCheck->contains(func_get_args());

        return $this->start()->isLessThanOrEqualTo($timePoint)
            && $this->end()->isGreaterThan($timePoint);
    }

    /**
     * Check if a given interval is contained within this interval.
     *
     * @param IntervalInterface $interval The interval to check.
     *
     * @return boolean True if this interval entirely contains the given interval; otherwise, false.
     */
    public function encompasses(IntervalInterface $interval)
    {
        $this->typeCheck->encompasses(func_get_args());

        return $this->start()->isLessThanOrEqualTo($interval->start())
            && $this->end()->isGreaterThanOrEqualTo($interval->end());
    }

    /**
     * Check if a given interval is at least partially contained within this interval.
     *
     * @param IntervalInterface $interval The interval to check.
     *
     * @return boolean True if this interval intersects the given interval; otherwise, false.
     */
    public function intersects(IntervalInterface $interval)
    {
        $this->typeCheck->intersects(func_get_args());

        return $this->start()->isLessThan($interval->end())
            && $this->end()->isGreaterThan($interval->start());
    }

    /**
     * @return Duration A duration representing the difference between start and end.
     */
    public function duration()
    {
        $this->typeCheck->duration(func_get_args());

        return $this->end()->differenceAsDuration($this->start());
    }

    /**
     * @return Period A period representing the difference between start and end.
     */
    public function period()
    {
        $this->typeCheck->period(func_get_args());

        return $this->end()->differenceAsPeriod($this->start());
    }

    /**
     * @return Iterator An iterator that yields each year in the interval.
     */
    public function byYear()
    {
        $this->typeCheck->byYear(func_get_args());

        return new YearIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each month in the interval.
     */
    public function byMonth()
    {
        $this->typeCheck->byMonth(func_get_args());

        return new MonthIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each day in the interval.
     */
    public function byDay()
    {
        $this->typeCheck->byDay(func_get_args());

        return new DayIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each hour in the interval.
     */
    public function byHour()
    {
        $this->typeCheck->byHour(func_get_args());

        return new HourIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each minute in the interval.
     */
    public function byMinute()
    {
        $this->typeCheck->byMinute(func_get_args());

        return new MinuteIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each second in the interval.
     */
    public function bySecond()
    {
        $this->typeCheck->bySecond(func_get_args());

        return new SecondIntervalIterator($this);
    }

    private $typeCheck;
}
