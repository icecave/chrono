<?php
namespace Icecave\Chrono;

class TimeZone
{
    public function __construct($offset, $isDST)
    {
        $this->offset = $offset;
        $this->isDST = $isDST;
    }

    public function hours()
    {
        return intval($this->offset() / 60);
    }

    public function minutes()
    {
        return $this->offset() % 60;
    }

    public function offset()
    {
        return $this->offset;
    }

    public function isUTC()
    {
        return $this->offset() === 0
            && !$this->isDST();
    }

    public function isDST()
    {
        return $this->isDST;
    }

    public function compare(TimeZone $timeZone)
    {
        return $this->offset() - $timezone->offset()
            || intval($this->isDST()) - intval($timezone->isDST());
    }

    public function __toString()
    {
        return sprintf(
            '%s%02d%02d',
            $this->hours() < 0 ? '-' : '+',
            abs($this->hours()),
            abs($this->minutes())
        );
    }

    private $offset;
    private $isDST;
}
