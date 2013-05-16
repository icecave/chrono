<?php
namespace Icecave\Chrono\TimeSpan;

use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\Iso8601Interface;
use Icecave\Chrono\Support\Calendar;
use Icecave\Chrono\Support\Iso8601;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;
use InvalidArgumentException;

/**
 * A duration represents a concrete amount of time.
 */
class Duration implements TimeSpanInterface, Iso8601Interface
{
    /**
     * @param integer $seconds The total number of seconds in the duration.
     */
    public function __construct($seconds = 0)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->seconds = $seconds;
    }

    /**
     * @param integer $weeks   The number of weeks in the duration.
     * @param integer $days    The number of days in the duration.
     * @param integer $hours   The number of hours in the duration.
     * @param integer $minutes The number of minutes in the duration.
     * @param integer $seconds The number of seconds in the duration.
     *
     * @return Duration
     */
    public static function fromComponents($weeks = 0, $days = 0, $hours = 0, $minutes = 0, $seconds = 0)
    {
        TypeCheck::get(__CLASS__)->fromComponents(func_get_args());

        $days += $weeks * 7;
        $hours += $days * 24;
        $minutes += $hours * 60;
        $seconds += $minutes * 60;

        return new self($seconds);
    }

    /**
     * Standard duration formats:
     *   PnYnMnDTnHnMnS (zero periods may be ommitted)
     *   PnW
     *   P<date>T<time>
     *
     * See link for the full specifics on formats.
     * @link http://en.wikipedia.org/wiki/ISO_8601#Durations
     *
     * Note: Decimal fractions are currently not supported.
     *
     * @param string $isoString A string containing a duration in any ISO-8601 compatible duration format.
     *
     * @return Duration The Duration constructed from the ISO compatible string.
     */
    public static function fromIsoString($isoString)
    {
        // TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

        $duration = Iso8601::parseDuration($isoString);

        $seconds = Calendar::approximateTotalSeconds(
            $duration['years'],
            $duration['months'],
            0,
            $duration['days'],
            $duration['hours'],
            $duration['minutes'],
            $duration['seconds']
        );

        return new self($seconds);
    }

    /**
     * @return integer The number of weeks in the duration.
     */
    public function weeks()
    {
        $this->typeCheck->weeks(func_get_args());

        return intval($this->totalSeconds() / 604800);
    }

    /**
     * @return integer The number of days in the duration, not including those that comprise whole weeks.
     */
    public function days()
    {
        $this->typeCheck->days(func_get_args());

        return intval(($this->totalSeconds() % 604800) / 86400);
    }

    /**
     * @return integer The number of hours in the duration, not including those that comprise whole days.
     */
    public function hours()
    {
        $this->typeCheck->hours(func_get_args());

        return intval(($this->totalSeconds() % 86400) / 3600);
    }

    /**
     * @return integer The number of minutes in the duration, not including those that comprise whole hours.
     */
    public function minutes()
    {
        $this->typeCheck->minutes(func_get_args());

        return intval(($this->totalSeconds() % 3600) / 60);
    }

    /**
     * @return integer The number of seconds in the duration, not including those that comprise whole minutes.
     */
    public function seconds()
    {
        $this->typeCheck->seconds(func_get_args());

        return intval($this->totalSeconds() % 60);
    }

    /**
     * @return integer The total number of whole days in the duration.
     */
    public function totalDays()
    {
        $this->typeCheck->totalDays(func_get_args());

        return intval($this->totalSeconds() / 86400);
    }

    /**
     * @return integer The total number of whole hours in the duration.
     */
    public function totalHours()
    {
        $this->typeCheck->totalHours(func_get_args());

        return intval($this->totalSeconds() / 3600);
    }

    /**
     * @return integer The total number of whole minutes in the duration.
     */
    public function totalMinutes()
    {
        $this->typeCheck->totalMinutes(func_get_args());

        return intval($this->totalSeconds() / 60);
    }

    /**
     * @return integer The total number seconds in the duration.
     */
    public function totalSeconds()
    {
        $this->typeCheck->totalSeconds(func_get_args());

        return $this->seconds;
    }

    /**
     * Perform a {@see strcmp} style comparison with another duration.
     *
     * @param Duration $duration The duration to compare.
     *
     * @return integer 0 if $this and $duration are equal, <0 if $this < $duration, or >0 if $this > $duration.
     */
    public function compare(Duration $duration)
    {
        $this->typeCheck->compare(func_get_args());

        return $this->totalSeconds() - $duration->totalSeconds();
    }

    /**
     * @param Duration $duration The duration to compare.
     *
     * @return boolean True if $this and $duration are equal.
     */
    public function isEqualTo(Duration $duration)
    {
        $this->typeCheck->isEqualTo(func_get_args());

        return $this->compare($duration) === 0;
    }

    /**
     * @param Duration $duration The duration to compare.
     *
     * @return boolean True if $this and $duration are not equal.
     */
    public function isNotEqualTo(Duration $duration)
    {
        $this->typeCheck->isNotEqualTo(func_get_args());

        return $this->compare($duration) !== 0;
    }

    /**
     * @param Duration $duration The duration to compare.
     *
     * @return boolean True if $this > $duration.
     */
    public function isGreaterThan(Duration $duration)
    {
        $this->typeCheck->isGreaterThan(func_get_args());

        return $this->compare($duration) > 0;
    }

    /**
     * @param Duration $duration The duration to compare.
     *
     * @return boolean True if $this < $duration.
     */
    public function isLessThan(Duration $duration)
    {
        $this->typeCheck->isLessThan(func_get_args());

        return $this->compare($duration) < 0;
    }

    /**
     * @param Duration $duration The duration to compare.
     *
     * @return boolean True if $this >= $duration.
     */
    public function isGreaterThanOrEqualTo(Duration $duration)
    {
        $this->typeCheck->isGreaterThanOrEqualTo(func_get_args());

        return $this->compare($duration) >= 0;
    }

    /**
     * @param Duration $duration The duration to compare.
     *
     * @return boolean True if $this <= $duration.
     */
    public function isLessThanOrEqualTo(Duration $duration)
    {
        $this->typeCheck->isLessThanOrEqualTo(func_get_args());

        return $this->compare($duration) <= 0;
    }

    /**
     * @return boolean True if the duration is zero seconds in length; otherwise, false.
     */
    public function isEmpty()
    {
        $this->typeCheck->isEmpty(func_get_args());

        return 0 === $this->totalSeconds();
    }

    /**
     * @return TimeSpanInterface
     */
    public function inverse()
    {
        $this->typeCheck->inverse(func_get_args());

        return new self(-$this->totalSeconds());
    }

    /**
     * Resolve the time span to a total number of seconds, using the given time point as the start of the span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return integer The total number of seconds.
     */
    public function resolveToSeconds(TimePointInterface $timePoint)
    {
        $this->typeCheck->resolveToSeconds(func_get_args());

        return $this->totalSeconds();
    }

    /**
     * Resolve the time span to a {@see Duration}, using the given time point as the start of the span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return Duration
     */
    public function resolveToDuration(TimePointInterface $timePoint)
    {
        $this->typeCheck->resolveToDuration(func_get_args());

        return $this;
    }

    /**
     * Resolve the time span to a {@see Period}, using the given time point as the start of the span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return Period
     */
    public function resolveToPeriod(TimePointInterface $timePoint)
    {
        $this->typeCheck->resolveToPeriod(func_get_args());

        return new Period(
            0,
            0,
            $this->totalDays(),
            $this->hours(),
            $this->minutes(),
            $this->seconds()
        );
    }

    /**
     * Resolve the time span an an {@see IntervalInterface} starting at the given time point, with a length equal to this time span.
     *
     * @param TimePointInterface $timePoint The start of the interval.
     *
     * @return IntervalInterface The end of the time span.
     */
    public function resolveToInterval(TimePointInterface $timePoint)
    {
        $this->typeCheck->resolveToInterval(func_get_args());

        return new Interval(
            $timePoint,
            $this->resolveToTimePoint($timePoint)
        );
    }

    /**
     * Resolve the time span to a time point after the given time point by the length of this span.
     *
     * @param TimePointInterface $timePoint The start of the time span.
     *
     * @return TimePointInterface
     */
    public function resolveToTimePoint(TimePointInterface $timePoint)
    {
        $this->typeCheck->resolveToTimePoint(func_get_args());

        return new DateTime(
            $timePoint->year(),
            $timePoint->month(),
            $timePoint->day(),
            $timePoint->hours(),
            $timePoint->minutes(),
            $timePoint->seconds() + $this->totalSeconds(),
            $timePoint->timeZone()
        );
    }

    /**
     * @return string
     */
    public function string()
    {
        $this->typeCheck->string(func_get_args());

        $chunks = array();

        if ($this->weeks()) {
            $chunks[] = $this->weeks() . 'w';
        }

        if ($this->days()) {
            $chunks[] = $this->days() . 'd';
        }

        $chunks[] = sprintf(
            '%02d:%02d:%02d',
            $this->hours(),
            $this->minutes(),
            $this->seconds()
        );

        return implode(' ', $chunks);
    }

    /**
     * @return string A string representing this object in an ISO compatible format (PnYnMnDTnHnMnS).
     */
    public function isoString()
    {
        // $this->typeCheck->isoString(func_get_args());

        $dateParts = '';
        if ($this->totalDays() !== 0) {
            $dateParts .= $this->totalDays() . 'D';
        }

        $timeParts = '';
        if ($this->hours() !== 0) {
            $timeParts .= $this->hours() . 'H';
        }
        if ($this->minutes() !== 0) {
            $timeParts .= $this->minutes() . 'M';
        }
        if ($this->seconds() !== 0) {
            $timeParts .= $this->seconds() . 'S';
        }

        if (strlen($timeParts) > 0) {
            $timeParts = 'T' . $timeParts;
        }

        return 'P' . $dateParts . $timeParts;
    }

    /**
     * @return string A string representing this object in an ISO compatible format (PnDTnHnMnS).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $typeCheck;
    private $seconds;
}
