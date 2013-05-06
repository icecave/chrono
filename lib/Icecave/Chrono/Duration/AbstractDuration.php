<?php
namespace Icecave\Chrono\Duration;

use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;

/**
 * A duration represents a concrete amount of time.
 */
abstract class AbstractDuration implements DurationInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * @return integer The number of weeks in the duration.
     */
    public function weeks()
    {
        $this->typeCheck->weeks(func_get_args());

        return intval($this->totalSeconds() / 604800);
    }

    /**
     * @return integer The number of days in the duration, not including those that comprise whole weeks.
     */
    public function days()
    {
        $this->typeCheck->days(func_get_args());

        return intval(($this->totalSeconds() % 604800) / 86400);
    }

    /**
     * @return integer The number of hours in the duration, not including those that comprise whole days.
     */
    public function hours()
    {
        $this->typeCheck->hours(func_get_args());

        return intval(($this->totalSeconds() % 86400) / 3600);
    }

    /**
     * @return integer The number of minutes in the duration, not including those that comprise whole hours.
     */
    public function minutes()
    {
        $this->typeCheck->minutes(func_get_args());

        return intval(($this->totalSeconds() % 3600) / 60);
    }

    /**
     * @return integer The number of seconds in the duration, not including those that comprise whole minutes.
     */
    public function seconds()
    {
        $this->typeCheck->seconds(func_get_args());

        return intval($this->totalSeconds() % 60);
    }

    /**
     * @return integer The total number of whole days in the duration.
     */
    public function totalDays()
    {
        $this->typeCheck->totalDays(func_get_args());

        return intval($this->totalSeconds() / 86400);
    }

    /**
     * @return integer The total number of whole hours in the duration.
     */
    public function totalHours()
    {
        $this->typeCheck->totalHours(func_get_args());

        return intval($this->totalSeconds() / 3600);
    }

    /**
     * @return integer The total number of whole minutes in the duration.
     */
    public function totalMinutes()
    {
        $this->typeCheck->totalMinutes(func_get_args());

        return intval($this->totalSeconds() / 60);
    }

    /**
     * @return boolean True if the duration is zero seconds in length; otherwise, false.
     */
    public function isEmpty()
    {
        $this->typeCheck->isEmpty(func_get_args());

        return 0 === $this->totalSeconds();
    }

    /**
     * Perform a {@see strcmp} style comparison with another duration.
     *
     * @param DurationInterface $duration The duration to compare.
     *
     * @return integer 0 if $this and $duration are equal, <0 if $this < $duration, or >0 if $this > $duration.
     */
    public function compare(DurationInterface $duration)
    {
        $this->typeCheck->compare(func_get_args());

        return $this->totalSeconds() - $duration->totalSeconds();
    }

    /**
     * Resolve the time span to a total number of seconds, using the given time point as the start of the span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return integer The total number of seconds.
     */
    public function resolve(TimePointInterface $timePoint)
    {
        $this->typeCheck->resolve(func_get_args());

        return $this->totalSeconds();
    }

    private $typeCheck;
}
