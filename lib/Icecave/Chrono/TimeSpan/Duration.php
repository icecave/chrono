<?php
namespace Icecave\Chrono\TimeSpan;

use DateInterval;
use Icecave\Chrono\DateTime;
use Icecave\Chrono\Interval\Interval;
use Icecave\Chrono\Interval\IntervalInterface;
use Icecave\Chrono\Iso8601Interface;
use Icecave\Chrono\Detail\Calendar;
use Icecave\Chrono\Detail\Iso8601;
use Icecave\Chrono\TimePointInterface;
use Icecave\Chrono\TypeCheck\TypeCheck;
use Icecave\Parity\AbstractComparable;
use Icecave\Parity\Exception\NotComparableException;
use Icecave\Parity\RestrictedComparableInterface;
use InvalidArgumentException;

/**
 * A duration represents a concrete amount of time.
 */
class Duration extends AbstractComparable implements TimeSpanInterface, Iso8601Interface, RestrictedComparableInterface
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
        TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

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
     * @param DateInterval $dateInterval The native PHP DateInterval.
     *
     * @return Duration The Duration constructed from the native PHP DateInterval.
     */
    public static function fromNativeDateInterval(DateInterval $dateInterval)
    {
        TypeCheck::get(__CLASS__)->fromNativeDateInterval(func_get_args());

        if ($dateInterval->y !== 0 || $dateInterval->m !== 0) {
            throw new InvalidArgumentException('Duration\'s can not be created from date intervals containing years or months.');
        }

        $duration = self::fromComponents(
            0,
            $dateInterval->d,
            $dateInterval->h,
            $dateInterval->i,
            $dateInterval->s
        );

        if ($dateInterval->invert) {
            return $duration->inverse();
        }

        return $duration;
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
     * Check if $this is able to be compared to another value.
     *
     * A return value of false indicates that calling $this->compare($value)
     * will throw an exception.
     *
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this can be compared to $value.
     */
    public function canCompare($value)
    {
        $this->typeCheck->canCompare(func_get_args());

        return $value instanceof Duration;
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
     * @param mixed $duration The duration to compare.
     *
     * @return integer                0 if $this and $duration are equal, <0 if $this < $duration, or >0 if $this > $duration.
     * @throws NotComparableException Indicates that the implementation does not know how to compare $this to $duration.
     */
    public function compare($duration)
    {
        $this->typeCheck->compare(func_get_args());

        if (!$this->canCompare($duration)) {
            throw new NotComparableException($this, $duration);
        }

        return $this->totalSeconds() - $duration->totalSeconds();
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

        $end = $this->resolveToTimePoint($timePoint);

        if ($end->isLessThan($timePoint)) {
            return new Interval($end, $timePoint);
        }

        return new Interval($timePoint, $end);
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
     * @return DateInterval A native PHP DateInterval instance representing this span.
     */
    public function nativeDateInterval()
    {
        $this->typeCheck->nativeDateInterval(func_get_args());

        return new DateInterval($this->isoString());
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
     * @return string A string representing this object in an ISO compatible duration format (PnYnMnDTnHnMnS).
     */
    public function isoString()
    {
        $this->typeCheck->isoString(func_get_args());

        return Iso8601::formatDuration(
            0,
            0,
            $this->totalDays(),
            $this->hours(),
            $this->minutes(),
            $this->seconds()
        );
    }

    /**
     * @return string A string representing this object in an ISO compatible duration format (PnYnMnDTnHnMnS).
     */
    public function __toString()
    {
        return $this->isoString();
    }

    private $typeCheck;
    private $seconds;
}
