<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\TimePointInterface;

/**
 * An interval represents a stretch of time between two known time points.
 */
interface IntervalInterface
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
     * @return boolean True if the interval indicates a non-zero duration; otherwise, false.
     */
    public function isEmpty();

    /**
     * Perform a strcmp style comparison with another interval.
     *
     * @param IntervalInterface $interval The interval to compare.
     *
     * @return integer 0 if $this and $interval are equal, <0 if $this < $interval, or >0 if $this > $interval.
     */
    public function compare(IntervalInterface $interval);

    /**
     * Check if a given time point is contained within this interval.
     *
     * @param TimePointInterface $timePoint The time point to check.
     * @return boolean True if this interval contains the given time point; otherwise, false.
     */
    public function contains(TimePointInterface $timePoint);

    /**
     * Check if a given interval is contained within this interval.
     *
     * @param IntervalInterface $interval The interval to check.
     * @return boolean True if this interval entirely contains the given interval; otherwise, false.
     */
    public function encompasses(IntervalInterface $interval);

    /**
     * Check if a given interval is at least partially contained within this interval.
     *
     * @param IntervalInterface $interval The interval to check.
     * @return boolean True if this interval intersects the given interval; otherwise, false.
     */
    public function intersects(IntervalInterface $interval);
}
