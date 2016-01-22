<?php

namespace Icecave\Chrono;

use Icecave\Chrono\Detail\Iso8601;
use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormattableInterface;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Parity\AbstractExtendedComparable;
use Icecave\Parity\Exception\NotComparableException;
use Icecave\Parity\SubClassComparableInterface;

class TimeZone extends AbstractExtendedComparable implements Iso8601Interface, FormattableInterface, SubClassComparableInterface
{
    /**
     * @param integer $offset The offset from UTC in seconds.
     * @param boolean $isDst  True if the timezone is currently honouring daylight saving time; otherwise, false.
     */
    public function __construct($offset = 0, $isDst = false)
    {
        $offset       = $offset % 86400;
        $this->offset = intval(round($offset / 60)) * 60;
        $this->isDst  = $isDst;
    }

    /**
     * Standard time zone formats:
     *   Z
     *   +/-hh
     *   +/-hhmm
     *   +/-hh:mm
     *
     * @link http://en.wikipedia.org/wiki/ISO_8601#Time_zone_designators
     *
     * @param string  $isoString A string containing a time zone in any ISO-8601 compatible time zone format, with the exception of allowing negative zero's.
     * @param boolean $isDst     True if the time zone is currently honouring daylight saving time; otheriwse, false.
     *
     * @return TimeZone The TimeZone constructed from the ISO compatible string.
     */
    public static function fromIsoString($isoString, $isDst = false)
    {
        $offset = Iso8601::parseTimeZone($isoString);

        return new self($offset, $isDst);
    }

    /**
     * @return integer The offset from UTC in seconds.
     */
    public function offset()
    {
        return $this->offset;
    }

    /**
     * @return boolean True if the timezone represents UTC (0 offset, no DST).
     */
    public function isUtc()
    {
        return $this->offset() === 0
            && !$this->isDst();
    }

    /**
     * @return boolean True if the timezone is currently honouring daylight saving time; otheriwse, false.
     */
    public function isDst()
    {
        return $this->isDst;
    }

    /**
     * Compare this object with another value, yielding a result according to the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * @param mixed $timeZone The timezone to compare.
     *
     * @return integer                0 if $this and $timeZone are equal, <0 if $this < $timeZone, or >0 if $this > $timeZone.
     * @throws NotComparableException Indicates that the implementation does not know how to compare $this to $timeZone.
     */
    public function compare($timeZone)
    {
        if (!$timeZone instanceof self) {
            throw new NotComparableException($this, $timeZone);
        }

        return $this->offset() - $timeZone->offset()
            ?: intval($this->isDst()) - intval($timeZone->isDst());
    }

    /**
     * @param string                  $formatSpecifier The format of the output string.
     * @param FormatterInterface|null $formatter       The formatter to use, or null to use the default.
     *
     * @return string The formatted string.
     */
    public function format($formatSpecifier, FormatterInterface $formatter = null)
    {
        if (null === $formatter) {
            $formatter = DefaultFormatter::instance();
        }

        return $formatter->formatTimeZone($this, $formatSpecifier);
    }

    /**
     * @return string A string representing this object in an ISO compatible time zone format ([+-]hh:mm).
     */
    public function isoString()
    {
        return Iso8601::formatTimeZone($this->offset());
    }

    /**
     * @return string A string representing this object in an ISO compatible time zone format ([+-]hh:mm).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $timeZone;
    private $offset;
    private $isDst;
}
