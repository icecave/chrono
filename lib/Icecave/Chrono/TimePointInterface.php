<?php
namespace Icecave\Chrono;

use DateTime as NativeDateTime;

/**
 * Represents a concrete point on the time continuum.
 */
interface TimePointInterface extends DateInterface
{
    /**
     * Perform a {@see strcmp} style comparison with another time point.
     *
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return integer 0 if $this and $timePoint are equal, <0 if $this < $timePoint, or >0 if $this > $timePoint.
     */
    public function compare(TimePointInterface $timePoint);

    /**
     * @return integer The number of seconds since unix epoch (1970-01-01 00:00:00+00:00).
     */
    public function unixTime();

    /**
     * @return NativeDateTime A native PHP DateTime instance representing this time point.
     */
    public function nativeDateTime();

    /**
     * Add a time span to the time point.
     *
     * @param TimeSpanInterface $timeSpan
     *
     * @return TimePointInterface
     */
    public function add(TimeSpanInterface $timeSpan);

    /**
     * Add a time span from the time point.
     *
     * @param TimeSpanInterface $timeSpan
     *
     * @return TimePointInterface
     */
    public function subtract(TimeSpanInterface $timeSpan);

    /**
     * Calculate the difference between this time point and another, representing the result as a duration.
     *
     * @param TimePointInterface $timePoint
     *
     * @return Duration
     */
    public function differenceAsDuration(TimePointInterface $timePoint);
}
