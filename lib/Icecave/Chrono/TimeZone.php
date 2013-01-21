<?php
namespace Icecave\Chrono;

use Icecave\Chrono\TypeCheck\TypeCheck;

class TimeZone
{
    /**
     * @param integer $offset The offset from UTC in seconds.
     * @param boolean $isDst  True if the timezone is currently honouring daylight saving time; otheriwse, false.
     */
    public function __construct($offset = 0, $isDst = false)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->offset = $offset;
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

    private $typeCheck;
    private $timeZone;
    private $offset;
    private $isDst;
}
