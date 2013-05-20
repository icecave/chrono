<?php
namespace Icecave\Chrono;

use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Chrono\Format\FormattableInterface;
use Icecave\Chrono\Detail\Iso8601;
use Icecave\Chrono\TypeCheck\TypeCheck;

class TimeZone implements Iso8601Interface, FormattableInterface
{
    /**
     * @param integer $offset The offset from UTC in seconds.
     * @param boolean $isDst  True if the timezone is currently honouring daylight saving time; otheriwse, false.
     */
    public function __construct($offset = 0, $isDst = false)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $offset = $offset % 86400;
        $this->offset = intval(round($offset / 60)) * 60;
        $this->isDst = $isDst;
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
        TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

        $offset = Iso8601::parseTimeZone($isoString);

        return new self($offset, $isDst);
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
     * @param TimeZone $timeZone The timeZone to compare.
     *
     * @return boolean True if $this and $timeZone are equal.
     */
    public function isEqualTo(TimeZone $timeZone)
    {
        $this->typeCheck->isEqualTo(func_get_args());

        return $this->compare($timeZone) === 0;
    }

    /**
     * @param TimeZone $timeZone The timeZone to compare.
     *
     * @return boolean True if $this and $timeZone are not equal.
     */
    public function isNotEqualTo(TimeZone $timeZone)
    {
        $this->typeCheck->isNotEqualTo(func_get_args());

        return $this->compare($timeZone) !== 0;
    }

    /**
     * @param TimeZone $timeZone The timeZone to compare.
     *
     * @return boolean True if $this > $timeZone.
     */
    public function isGreaterThan(TimeZone $timeZone)
    {
        $this->typeCheck->isGreaterThan(func_get_args());

        return $this->compare($timeZone) > 0;
    }

    /**
     * @param TimeZone $timeZone The timeZone to compare.
     *
     * @return boolean True if $this < $timeZone.
     */
    public function isLessThan(TimeZone $timeZone)
    {
        $this->typeCheck->isLessThan(func_get_args());

        return $this->compare($timeZone) < 0;
    }

    /**
     * @param TimeZone $timeZone The timeZone to compare.
     *
     * @return boolean True if $this >= $timeZone.
     */
    public function isGreaterThanOrEqualTo(TimeZone $timeZone)
    {
        $this->typeCheck->isGreaterThanOrEqualTo(func_get_args());

        return $this->compare($timeZone) >= 0;
    }

    /**
     * @param TimeZone $timeZone The timeZone to compare.
     *
     * @return boolean True if $this <= $timeZone.
     */
    public function isLessThanOrEqualTo(TimeZone $timeZone)
    {
        $this->typeCheck->isLessThanOrEqualTo(func_get_args());

        return $this->compare($timeZone) <= 0;
    }

    /**
     * @param string                  $formatSpecifier The format of the output string.
     * @param FormatterInterface|null $formatter       The formatter to use, or null to use the default.
     *
     * @return string The formatted string.
     */
    public function format($formatSpecifier, FormatterInterface $formatter = null)
    {
        $this->typeCheck->format(func_get_args());

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
        $this->typeCheck->isoString(func_get_args());

        return Iso8601::formatTimeZone($this->offset());
    }

    /**
     * @return string A string representing this object in an ISO compatible time zone format ([+-]hh:mm).
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
