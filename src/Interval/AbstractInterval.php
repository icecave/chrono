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
use Icecave\Parity\AbstractExtendedComparable;
use Icecave\Parity\Exception\NotComparableException;

abstract class AbstractInterval extends AbstractExtendedComparable implements IntervalInterface
{
    /**
     * @return boolean True if the interval indicates a non-zero duration; otherwise, false.
     */
    public function isEmpty()
    {
        return $this->start()->isEqualTo($this->end());
    }

    /**
     * Check if $this is able to be compared to another value.
     *
     * A return value of false indicates that calling $this->compare($value)
     * will throw an exception.
     *
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this can be compared to $value.
     */
    public function canCompare($value)
    {
        return $value instanceof IntervalInterface;
    }

    /**
     * Compare this object with another value, yielding a result according to the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * @param mixed $interval The interval to compare.
     *
     * @return integer                0 if $this and $interval are equal, <0 if $this < $interval, or >0 if $this > $interval.
     * @throws NotComparableException Indicates that the implementation does not know how to compare $this to $value.
     */
    public function compare($interval)
    {
        if (!$this->canCompare($interval)) {
            throw new NotComparableException($this, $interval);
        }

        return $this->start()->compare($interval->start())
            ?: $this->end()->compare($interval->end());
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
        return $this->start()->isLessThan($interval->end())
            && $this->end()->isGreaterThan($interval->start());
    }

    /**
     * @return Duration A duration representing the difference between start and end.
     */
    public function duration()
    {
        return $this->end()->differenceAsDuration($this->start());
    }

    /**
     * @return Period A period representing the difference between start and end.
     */
    public function period()
    {
        return $this->end()->differenceAsPeriod($this->start());
    }

    /**
     * @return Iterator An iterator that yields each year in the interval.
     */
    public function byYear()
    {
        return new YearIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each month in the interval.
     */
    public function byMonth()
    {
        return new MonthIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each day in the interval.
     */
    public function byDay()
    {
        return new DayIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each hour in the interval.
     */
    public function byHour()
    {
        return new HourIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each minute in the interval.
     */
    public function byMinute()
    {
        return new MinuteIntervalIterator($this);
    }

    /**
     * @return Iterator An iterator that yields each second in the interval.
     */
    public function bySecond()
    {
        return new SecondIntervalIterator($this);
    }
}
