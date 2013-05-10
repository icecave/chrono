<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Duration\Duration;
use Icecave\Chrono\TimePointInterface;
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

        return $this->start()->compare($this->end()) === 0;
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

        return $this->start()->compare($timePoint) <= 0
            && $this->end()->compare($timePoint) > 0;
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

        return $this->start()->compare($interval->start()) <= 0
            && $this->end()->compare($interval->end()) >= 0;
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

        return $this->start()->compare($interval->end()) < 0
            && $this->end()->compare($interval->start()) > 0;
    }

    /**
     * @return DurationInterface A duration representing the difference between start and end.
     */
    public function duration()
    {
        $this->typeCheck->duration(func_get_args());

        return new Duration($this->end()->unixTime() - $this->start()->unixTime());
    }

    private $typeCheck;
}
