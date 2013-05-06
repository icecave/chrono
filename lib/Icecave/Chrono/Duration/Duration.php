<?php
namespace Icecave\Chrono\Duration;

use Icecave\Chrono\TypeCheck\TypeCheck;

/**
 * A duration represents a concrete amount of time.
 */
class Duration extends AbstractDuration
{
    /**
     * @param integer $seconds The total number of seconds in the duration.
     */
    public function __construct($seconds = 0)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->seconds = $seconds;

        parent::__construct();
    }

    /**
     * @param integer $weeks   The number of weeks in the duration.
     * @param integer $days    The number of days in the duration.
     * @param integer $hours   The number of hours in the duration.
     * @param integer $minutes The number of minutes in the duration.
     * @param integer $seconds The number of seconds in the duration.
     *
     * @return Duration
     */
    public static function fromComponents($weeks = 0, $days = 0, $hours = 0, $minutes = 0, $seconds = 0)
    {
        TypeCheck::get(__CLASS__)->fromComponents(func_get_args());

        $days += $weeks * 7;
        $hours += $days * 24;
        $minutes += $hours * 60;
        $seconds += $minutes * 60;

        return new self($seconds);
    }

    /**
     * @return integer The total number seconds in the duration.
     */
    public function totalSeconds()
    {
        $this->typeCheck->totalSeconds(func_get_args());

        return $this->seconds;
    }

    private $typeCheck;
    private $seconds;
}
