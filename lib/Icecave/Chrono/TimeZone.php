<?php
namespace Icecave\Chrono;

class TimeZone
{
    /**
     * @param integer $offset
     * @param boolean $isDst
     */
    public function __construct($offset = 0, $isDst = false)
    {
        $this->offset = $offset;
        $this->isDst = $isDst;
    }

    public function offset()
    {
        return $this->offset;
    }

    public function isUtc()
    {
        return $this->offset() === 0
            && !$this->isDst();
    }

    public function isDst()
    {
        return $this->isDst;
    }

    public function compare(TimeZone $timeZone)
    {
        return $this->offset() - $timeZone->offset()
            ?: intval($this->isDst()) - intval($timeZone->isDst());
    }

    private $offset;
    private $isDst;
}
