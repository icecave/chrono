<?php

namespace Icecave\Chrono\Interval;

use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TimeSpan\Duration;
use Icecave\Chrono\TimeSpan\Period;
use Icecave\Parity\ExtendedComparableInterface;
use Icecave\Parity\RestrictedComparableInterface;

/**
 * An interval represents a stretch of time between two known time points.
 */
interface IntervalInterface extends ExtendedComparableInterface, RestrictedComparableInterface
{
    /**
     * @return TimePointInterface The start of the interval.
     */
    public function start();

    /**
     * @return TimePointInterface The end of the interval.
     */
    public function end();

    /**
     * @return boolean True if the interval indicates a zero duration; otherwise, false.
     */
    public function isEmpty();

    /**
     * Check if a given time point is contained within this interval.
     *
     * @param TimePointInterface $timePoint The time point to check.
     *
     * @return boolean True if this interval contains the given time point; otherwise, false.
     */
    public function contains(TimePointInterface $timePoint);

    /**
     * Check if a given interval is contained within this interval.
     *
     * @param IntervalInterface $interval The interval to check.
     *
     * @return boolean True if this interval entirely contains the given interval; otherwise, false.
     */
    public function encompasses(IntervalInterface $interval);

    /**
     * Check if a given interval is at least partially contained within this interval.
     *
     * @param IntervalInterface $interval The interval to check.
     *
     * @return boolean True if this interval intersects the given interval; otherwise, false.
     */
    public function intersects(IntervalInterface $interval);

    /**
     * @return Duration A duration representing the difference between start and end.
     */
    public function duration();

    /**
     * @return Period A period representing the difference between start and end.
     */
    public function period();

    /**
     * @return Iterator An iterator that yields each year in the interval.
     */
    public function byYear();

    /**
     * @return Iterator An iterator that yields each month in the interval.
     */
    public function byMonth();

    /**
     * @return Iterator An iterator that yields each day in the interval.
     */
    public function byDay();

    /**
     * @return Iterator An iterator that yields each hour in the interval.
     */
    public function byHour();

    /**
     * @return Iterator An iterator that yields each minute in the interval.
     */
    public function byMinute();

    /**
     * @return Iterator An iterator that yields each second in the interval.
     */
    public function bySecond();
}
