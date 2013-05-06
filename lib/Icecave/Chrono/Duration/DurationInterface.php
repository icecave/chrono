<?php
namespace Icecave\Chrono\Duration;

/**
 * A duration represents a concrete amount of time.
 */
interface DurationInterface
{
    /**
     * @return integer The number of weeks in the duration.
     */
    public function weeks();

    /**
     * @return integer The number of days in the duration, not including those that comprise whole weeks.
     */
    public function days();

    /**
     * @return integer The number of hours in the duration, not including those that comprise whole days.
     */
    public function hours();

    /**
     * @return integer The number of minutes in the duration, not including those that comprise whole hours.
     */
    public function minutes();

    /**
     * @return integer The number of seconds in the duration, not including those that comprise whole minutes.
     */
    public function seconds();

    /**
     * @return integer The total number of whole days in the duration.
     */
    public function totalDays();

    /**
     * @return integer The total number of whole hours in the duration.
     */
    public function totalHours();

    /**
     * @return integer The total number of whole minutes in the duration.
     */
    public function totalMinutes();

    /**
     * @return integer The total number seconds in the duration.
     */
    public function totalSeconds();

    /**
     * @return boolean True if the duration is zero seconds in length; otherwise, false.
     */
    public function isEmpty();

    /**
     * Perform a {@see strcmp} style comparison with another duration.
     *
     * @param DurationInterface $duration The duration to compare.
     *
     * @return integer 0 if $this and $duration are equal, <0 if $this < $duration, or >0 if $this > $duration.
     */
    public function compare(DurationInterface $duration);
}
