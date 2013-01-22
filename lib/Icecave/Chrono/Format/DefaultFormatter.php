<?php
namespace Icecave\Chrono\Format;

use Icecave\Chrono\Date;
use Icecave\Chrono\Time;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;

/**
 * A string formatter that accets {@see date()} compatible format specifiers.
 */
class DefaultFormatter implements FormatterInterface
{
    /**
     * Escape any special characters in the string so that they are not substituted
     * for date/time components when used as a format specifier.
     *
     * @param string $string The string to escape.
     *
     * @return string The escaped string.
     */
    public function escape($string)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @param Date   $date            The date to format.
     * @param string $formatSpecifier The format of the output string.
     *
     * @return string The formatted date.
     */
    public function formatDate(Date $date, $formatSpecifier)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @param Time   $Time            The time to format.
     * @param string $formatSpecifier The format of the output string.
     *
     * @return string The formatted time.
     */
    public function formatTime(Time $Time, $formatSpecifier)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @param DateTime $dateTime        The date/time to format.
     * @param string   $formatSpecifier The format of the output string.
     *
     * @return string The formatted date/time.
     */
    public function formatDateTime(DateTime $dateTime, $formatSpecifier)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @param TimeZone $timeZone        The timezone to format.
     * @param string   $formatSpecifier The format of the output string.
     *
     * @return string The formatted timezone.
     */
    public function formatTimeZone(TimeZone $timeZone, $formatSpecifier)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @return DefaultFormatter The global instance of the default formatter.
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private static $instance;
}
