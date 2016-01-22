<?php

namespace Icecave\Chrono\Format;

use Icecave\Chrono\Date;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeOfDay;
use Icecave\Chrono\TimeZone;

/**
 * Base interface for string formatters.
 */
interface FormatterInterface
{
    /**
     * Escape any special characters in the string so that they are not substituted
     * for date/time components when used as a format specifier.
     *
     * @param string $string The string to escape.
     *
     * @return string The escaped string.
     */
    public function escape($string);

    /**
     * @param Date   $date            The date to format.
     * @param string $formatSpecifier The format of the output string.
     *
     * @return string The formatted date.
     */
    public function formatDate(Date $date, $formatSpecifier);

    /**
     * @param TimeOfDay $time            The time to format.
     * @param string    $formatSpecifier The format of the output string.
     *
     * @return string The formatted time.
     */
    public function formatTimeOfDay(TimeOfDay $time, $formatSpecifier);

    /**
     * @param DateTime $dateTime        The date/time to format.
     * @param string   $formatSpecifier The format of the output string.
     *
     * @return string The formatted date/time.
     */
    public function formatDateTime(DateTime $dateTime, $formatSpecifier);

    /**
     * @param TimeZone $timeZone        The timezone to format.
     * @param string   $formatSpecifier The format of the output string.
     *
     * @return string The formatted timezone.
     */
    public function formatTimeZone(TimeZone $timeZone, $formatSpecifier);
}
