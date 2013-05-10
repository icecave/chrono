<?php
namespace Icecave\Chrono;

use Icecave\Chrono\Duration\Duration;
use Icecave\Chrono\TypeCheck\TypeCheck;

/**
 * Represents a concrete point on the time continuum.
 */
abstract class AbstractTimePoint implements TimePointInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * Perform a {@see strcmp} style comparison with another time point.
     *
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return integer 0 if $this and $timePoint are equal, <0 if $this < $timePoint, or >0 if $this > $timePoint.
     */
    public function compare(TimePointInterface $timePoint)
    {
        $this->typeCheck->compare(func_get_args());

        return $this->unixTime() - $timePoint->unixTime();
    }

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this and $timePoint are equal.
     */
    public function isEqualTo(TimePointInterface $timePoint)
    {
        $this->typeCheck->isEqualTo(func_get_args());

        return $this->compare($timePoint) === 0;
    }

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this and $timePoint are not equal.
     */
    public function isNotEqualTo(TimePointInterface $timePoint)
    {
        $this->typeCheck->isNotEqualTo(func_get_args());

        return $this->compare($timePoint) !== 0;
    }

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this > $timePoint.
     */
    public function isGreaterThan(TimePointInterface $timePoint)
    {
        $this->typeCheck->isGreaterThan(func_get_args());

        return $this->compare($timePoint) > 0;
    }

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this < $timePoint.
     */
    public function isLessThan(TimePointInterface $timePoint)
    {
        $this->typeCheck->isLessThan(func_get_args());

        return $this->compare($timePoint) < 0;
    }

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this >= $timePoint.
     */
    public function isGreaterThanOrEqualTo(TimePointInterface $timePoint)
    {
        $this->typeCheck->isGreaterThanOrEqualTo(func_get_args());

        return $this->compare($timePoint) >= 0;
    }

    /**
     * @param TimePointInterface $timePoint The time point to compare.
     *
     * @return boolean True if $this <= $timePoint.
     */
    public function isLessThanOrEqualTo(TimePointInterface $timePoint)
    {
        $this->typeCheck->isLessThanOrEqualTo(func_get_args());

        return $this->compare($timePoint) <= 0;
    }

    /**
     * Calculate the difference between this time point and another, representing the result as a duration.
     *
     * @param TimePointInterface $timePoint
     *
     * @return Duration
     */
    public function differenceAsDuration(TimePointInterface $timePoint)
    {
        $this->typeCheck->differenceAsDuration(func_get_args());

        return new Duration($this->unixTime() - $timePoint->unixTime());
    }

    private $typeCheck;
}
