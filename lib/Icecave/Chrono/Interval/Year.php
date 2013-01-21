<?php
namespace Icecave\Chrono\Interval;

use Icecave\Chrono\Date;
use Icecave\Chrono\Support\Calendar;
use Icecave\Chrono\TypeCheck\TypeCheck;

class Year extends AbstractInterval
{
    /**
     * @param integer $ordinal The year number.
     */
    public function __construct($ordinal)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->ordinal = $ordinal;
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

        return new Date($this->ordinal(), 12, 31);
    }

    /**
     * @return integer The number of days included in this interval.
     */
    public function numberOfDays()
    {
        $this->typeCheck->numberOfDays(func_get_args());

        if ($this->isLeapYear()) {
            return 366;
        }
        return 365;
    }

    /**
     * @return boolean True if this year interval represents a leap year; otherwise, false.
     */
    public function isLeapYear()
    {
        $this->typeCheck->isLeapYear(func_get_args());

        return Calendar::isLeapYear($this->ordinal());
    }

    public function __toString()
    {
        $this->typeCheck->validateToString(func_get_args());

        return sprintf('%04d', $this->ordinal());
    }

    private $typeCheck;
    private $ordinal;
}
