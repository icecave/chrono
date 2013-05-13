<?php
namespace Icecave\Chrono;

use DateTime as NativeDateTime;
use Icecave\Chrono\TimeSpan\TimeSpanInterface;

/**
 * Represents a concrete point on the time continuum.
 */
interface TimePointInterface extends DateInterface, TimeInterface
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
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this and $timePoint are equal.
     */
    public function isEqualTo(TimePointInterface $timePoint);

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this and $timePoint are not equal.
     */
    public function isNotEqualTo(TimePointInterface $timePoint);

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this > $timePoint.
     */
    public function isGreaterThan(TimePointInterface $timePoint);

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this < $timePoint.
     */
    public function isLessThan(TimePointInterface $timePoint);

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this >= $timePoint.
     */
    public function isGreaterThanOrEqualTo(TimePointInterface $timePoint);

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this <= $timePoint.
     */
    public function isLessThanOrEqualTo(TimePointInterface $timePoint);

    /**
     * @return integer The number of seconds since unix epoch (1970-01-01 00:00:00+00:00).
     */
    public function unixTime();

    /**
     * @return TimeZone The time zone of the time point.
     */
    public function timeZone();

    /**
     * @return NativeDateTime A native PHP DateTime instance representing this time point.
     */
    public function nativeDateTime();

    /**
     * Add a time span to the time point.
     *
     * @param TimeSpanInterface|integer $timeSpan A time span instance, or an integer representing seconds.
     *
     * @return TimePointInterface
     */
    public function add($timeSpan);

    /**
     * Subtract a time span from the time point.
     *
     * @param TimeSpanInterface|integer $timeSpan A time span instance, or an integer representing seconds.
     *
     * @return TimePointInterface
     */
    public function subtract($timeSpan);

    /**
     * Calculate the difference between this time point and another in seconds.
     *
     * @param TimePointInterface $timePoint
     *
     * @return integer
     */
    public function differenceAsSeconds(TimePointInterface $timePoint);

    /**
     * Calculate the difference between this time point and another, representing the result as a duration.
     *
     * @param TimePointInterface $timePoint
     *
     * @return Duration
     */
    public function differenceAsDuration(TimePointInterface $timePoint);
}
