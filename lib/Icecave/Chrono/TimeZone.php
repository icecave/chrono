<?php
namespace Icecave\Chrono;

use Icecave\Chrono\Format\DefaultFormatter;
use Icecave\Chrono\Format\FormatterInterface;
use Icecave\Chrono\Format\FormattableInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;
use InvalidArgumentException;

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
     * @param string  $isoTimeZone A string containing a time zone any ISO-8601 compatible format, with the exception of allowing negative zero's.
     * @param boolean $isDst       True if the timezone is currently honouring daylight saving time; otheriwse, false.
     *
     * @return TimeZone The TimeZone constructed from the ISO compatible string.
     */
    public static function fromIsoString($isoTimeZone, $isDst = false)
    {
        TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

        $matches = array();
        if (preg_match(self::FORMAT_UTC, $isoTimeZone, $matches) === 1) {
            $offset = 0;
        } elseif (preg_match(self::FORMAT_OFFSET, $isoTimeZone, $matches) === 1) {
            $sign = trim($matches[1]);
            $hour = intval($matches[2]);
            $minute = count($matches) > 4 ? intval($matches[4]) : 0;

            $offset = intval(($hour * 60 * 60) + ($minute * 60));
            if ($sign === '-') {
                $offset = -$offset;
            }
        } else {
            throw new InvalidArgumentException('Invalid ISO time zone: "' . $isoTimeZone . '".');
        }

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
     * @return string A string representing this object in an ISO compatible format ([+-]HH:MM).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        $seconds = abs($this->offset);
        $minutes = ($seconds % 3600) / 60;
        $hours   = $seconds / 3600;

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

    const FORMAT_UTC    = '/^(Z)$/';
    const FORMAT_OFFSET = '/^([+-])(\d\d)(:?(\d\d))?$/';

    private $typeCheck;
    private $timeZone;
    private $offset;
    private $isDst;
}
