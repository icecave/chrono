<?php
namespace Icecave\Chrono\TimeSpan;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\Support\Normalizer;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;

class Period implements TimeSpanInterface
{
    /**
     * @param integer $years   The years in the period.
     * @param integer $months  The months in the period.
     * @param integer $days    The days in the period.
     * @param integer $hours   The hours in the period.
     * @param integer $minutes The minutes in the period.
     * @param integer $seconds The seconds in the period.
     */
    public function __construct(
        $years = 0,
        $months = 0,
        $days = 0,
        $hours = 0,
        $minutes = 0,
        $seconds = 0
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->years = $years;
        $this->months = $months;
        $this->days = $days;
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
    }

    /**
     * @return integer The number of years in the period.
     */
    public function years()
    {
        return $this->years;
    }

    /**
     * @return integer The number of months in the period.
     */
    public function months()
    {
        return $this->months;
    }

    /**
     * @return integer The number of days in the period.
     */
    public function days()
    {
        return $this->days;
    }

    /**
     * @return integer The number of hours in the period.
     */
    public function hours()
    {
        return $this->hours;
    }

    /**
     * @return integer The number of minutes in the period.
     */
    public function minutes()
    {
        return $this->minutes;
    }

    /**
     * @return integer The number of seconds in the period.
     */
    public function seconds()
    {
        return $this->seconds;
    }

    public function approximateTotalSeconds()
    {
        $seconds  = $this->seconds();
        $seconds += $this->minutes() * 60;
        $seconds += $this->hours() * 3600;

        // avg days in year = 365.25
        // average seconds in year = 365.25 * 86,400 = 31,557,600
        // average seconds in month = 31,557,600 / 12 = 2,629,800
        $seconds += $this->days() * 86400;
        $seconds += $this->months() * 2629800;
        $seconds += $this->years() * 31557600;

        return $seconds;
    }

    /**
     * Perform a {@see strcmp} style comparison with another duration.
     *
     * @param Period $period The period to compare.
     *
     * @return integer 0 if $this and $period are equal, <0 if $this < $period, or >0 if $this > $period.
     */
    public function compare(Period $period)
    {
        $this->typeCheck->compare(func_get_args());

        return $this->years() - $period->years()
            ?: $this->months() - $period->months()
            ?: $this->days() - $period->days()
            ?: $this->hours() - $period->hours()
            ?: $this->minutes() - $period->minutes()
            ?: $this->seconds() - $period->seconds();
    }

    /**
     * @param Period $period The period to compare.
     *
     * @return boolean True if $this and $period are equal.
     */
    public function isEqualTo(Period $period)
    {
        $this->typeCheck->isEqualTo(func_get_args());

        return $this->compare($period) === 0;
    }

    /**
     * @param Period $period The period to compare.
     *
     * @return boolean True if $this and $period are not equal.
     */
    public function isNotEqualTo(Period $period)
    {
        $this->typeCheck->isNotEqualTo(func_get_args());

        return $this->compare($period) !== 0;
    }

    /**
     * @param Period $period The period to compare.
     *
     * @return boolean True if $this > $period.
     */
    public function isGreaterThan(Period $period)
    {
        $this->typeCheck->isGreaterThan(func_get_args());

        return $this->compare($period) > 0;
    }

    /**
     * @param Period $period The period to compare.
     *
     * @return boolean True if $this < $period.
     */
    public function isLessThan(Period $period)
    {
        $this->typeCheck->isLessThan(func_get_args());

        return $this->compare($period) < 0;
    }

    /**
     * @param Period $period The period to compare.
     *
     * @return boolean True if $this >= $period.
     */
    public function isGreaterThanOrEqualTo(Period $period)
    {
        $this->typeCheck->isGreaterThanOrEqualTo(func_get_args());

        return $this->compare($period) >= 0;
    }

    /**
     * @param Period $period The period to compare.
     *
     * @return boolean True if $this <= $period.
     */
    public function isLessThanOrEqualTo(Period $period)
    {
        $this->typeCheck->isLessThanOrEqualTo(func_get_args());

        return $this->compare($period) <= 0;
    }

    /**
     * @return boolean True if the period is zero seconds in length; otherwise, false.
     */
    public function isEmpty()
    {
        $this->typeCheck->isEmpty(func_get_args());

        return 0 === $this->years()
            && 0 === $this->months()
            && 0 === $this->days()
            && 0 === $this->hours()
            && 0 === $this->minutes()
            && 0 === $this->seconds();
    }

    /**
     * @return TimeSpanInterface
     */
    public function inverse()
    {
        return new self(
            -$this->years(),
            -$this->months(),
            -$this->days(),
            -$this->hours(),
            -$this->minutes(),
            -$this->seconds()
        );
    }

    /**
     * Resolve the time span to a total number of seconds, using the given time point as the start of the span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return integer The total number of seconds.
     */
    public function resolveToSeconds(TimePointInterface $timePoint)
    {
        return $this->resolveToTimePoint($timePoint)->differenceAsSeconds($timePoint);
    }

    /**
     * Resolve the time span to a {@see Duration}, using the given time point as the start of the span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return Duration
     */
    public function resolveToDuration(TimePointInterface $timePoint)
    {
        return $this->resolveToTimePoint($timePoint)->differenceAsDuration($timePoint);
    }

    /**
     * Resolve the time span to a {@see Period}, using the given time point as the start of the span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return Period
     */
    public function resolveToPeriod(TimePointInterface $timePoint)
    {
        return $this;
    }

    /**
     * Resolve the time span an an {@see IntervalInterface} starting at the given time point, with a length equal to this time span.
     *
     * @param TimePointInterface $timePoint The start of the interval.
     *
     * @return IntervalInterface The end of the time span.
     */
    public function resolveToInterval(TimePointInterface $timePoint)
    {
        return new Interval(
            $timePoint,
            $this->resolveToTimePoint($timePoint)
        );
    }

    /**
     * Resolve the time span to a time point after the given time point by the length of this span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return TimePointInterface
     */
    public function resolveToTimePoint(TimePointInterface $timePoint)
    {
        return new DateTime(
            $timePoint->year() + $this->years(),
            $timePoint->month() + $this->months(),
            $timePoint->day() + $this->days(),
            $timePoint->hours() + $this->hours(),
            $timePoint->minutes() + $this->minutes(),
            $timePoint->seconds() + $this->seconds(),
            $timePoint->timeZone()
        );
    }

    private $typeCheck;
    private $years;
    private $months;
    private $days;
    private $hours;
    private $minutes;
    private $seconds;
}
