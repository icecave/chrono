<?php
namespace Icecave\Chrono;

use Icecave\Chrono\TypeCheck\TypeCheck;

class TimeZone implements Iso8601Interface
{
    /**
     * @param integer $offset The offset from UTC in seconds.
     * @param boolean $isDst  True if the timezone is currently honouring daylight saving time; otheriwse, false.
     */
    public function __construct($offset = 0, $isDst = false)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->offset = intval(round($offset / 60)) * 60;
        $this->isDst = $isDst;
    }

    /**
     * @return integer The offset from UTC in seconds.
     */
    public function offset()
    {
        $this->typeCheck->offset(func_get_args());

        return $this->offset;
    }

    /**
     * @return boolean True if the timezone represents UTC (0 offset, no DST).
     */
    public function isUtc()
    {
        $this->typeCheck->isUtc(func_get_args());

        return $this->offset() === 0
            && !$this->isDst();
    }

    /**
     * @return boolean True if the timezone is currently honouring daylight saving time; otheriwse, false.
     */
    public function isDst()
    {
        $this->typeCheck->isDst(func_get_args());

        return $this->isDst;
    }

    /**
     * Perform a {@see strcmp} style comparison with another timezone.
     *
     * @param TimeZone $timeZone The timezone to compare.
     *
     * @return integer 0 if $this and $timeZone are equal, <0 if $this < $timeZone, or >0 if $this > $timeZone.
     */
    public function compare(TimeZone $timeZone)
    {
        $this->typeCheck->compare(func_get_args());

        return $this->offset() - $timeZone->offset()
            ?: intval($this->isDst()) - intval($timeZone->isDst());
    }

    /**
     * @return string A string representing this object in an ISO compatible format ([+-]HH:MM).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        $seconds = abs($this->offset);
        $hours   = $seconds / 3600;
        $minutes = ($seconds % 3600) / 60;

        return sprintf(
            '%s%02d:%02d',
            $this->offset >= 0 ? '+' : '-',
            $hours,
            $minutes
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible format ([+-]HH:MM).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $typeCheck;
    private $timeZone;
    private $offset;
    private $isDst;
}
