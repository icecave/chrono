<?php
namespace Icecave\Chrono\Format;

use Icecave\Chrono\Date;
use Icecave\Chrono\Time;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\TimeZone;

/**
 * Base interface for string formatters.
 */
interface FormatterInterface
{
    /**
     * @param Date   $date            The date to format.
     * @param string $formatSpecifier The format of the output string.
     *
     * @return string The formatted date.
     */
    public function formatDate(Date $date, $formatSpecifier);

    /**
     * @param Time   $Time            The time to format.
     * @param string $formatSpecifier The format of the output string.
     *
     * @return string The formatted time.
     */
    public function formatTime(Time $Time, $formatSpecifier);

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
