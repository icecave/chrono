<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\Iso8601Interface;
use Icecave\Chrono\Support\Calendar;
use Icecave\Chrono\TypeCheck\TypeCheck;

class Year extends AbstractInterval implements Iso8601Interface
{
    /**
     * @param integer $ordinal The year number.
     */
    public function __construct($ordinal)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->ordinal = $ordinal;

        parent::__construct();
    }

    /**
     * @param TimePointInterface $timePoint The time point to create from.
     *
     * @return Year The Year constructed from the given time point.
     */
    public static function fromTimePoint(TimePointInterface $timePoint)
    {
        TypeCheck::get(__CLASS__)->fromTimePoint(func_get_args());

        return new self($timePoint->year());
    }

    /**
     * @return integer The year number.
     */
    public function ordinal()
    {
        $this->typeCheck->ordinal(func_get_args());

        return $this->ordinal;
    }

    /**
     * @return Date The start of the interval.
     */
    public function start()
    {
        $this->typeCheck->start(func_get_args());

        return new Date($this->ordinal(), 1, 1);
    }

    /**
     * @return Date The end of the interval.
     */
    public function end()
    {
        $this->typeCheck->end(func_get_args());

        return new Date($this->ordinal() + 1, 1, 1);
    }

    /**
     * @return integer The number of days included in this interval.
     */
    public function numberOfDays()
    {
        $this->typeCheck->numberOfDays(func_get_args());

        return Calendar::daysInyear($this->ordinal());
    }

    /**
     * @return boolean True if this year interval represents a leap year; otherwise, false.
     */
    public function isLeapYear()
    {
        $this->typeCheck->isLeapYear(func_get_args());

        return Calendar::isLeapYear($this->ordinal());
    }

    /**
     * @return string A string representing this object in an ISO compatible format (YYYY).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        return sprintf('%04d', $this->ordinal());
    }

    /**
     * @return string A string representing this object in an ISO compatible format (YYYY).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $typeCheck;
    private $ordinal;
}
