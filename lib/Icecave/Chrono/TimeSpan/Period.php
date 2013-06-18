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

class Period extends AbstractComparable implements TimeSpanInterface, Iso8601Interface, RestrictedComparableInterface
{
    /**
     * @param integer $years   The years in the period.
     * @param integer $months  The months in the period.
     * @param integer $days    The days in the period.
     * @param integer $hours   The hours in the period.
     * @param integer $minutes The minutes in the period.
     * @param integer $seconds The seconds in the period.
     */
    public function __construct(
        $years = 0,
        $months = 0,
        $days = 0,
        $hours = 0,
        $minutes = 0,
        $seconds = 0
    ) {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->years = $years;
        $this->months = $months;
        $this->days = $days;
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
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
     * @param string $isoString A string containing a period in any ISO-8601 compatible duration format.
     *
     * @return Period The Period constructed from the ISO compatible string.
     */
    public static function fromIsoString($isoString)
    {
        TypeCheck::get(__CLASS__)->fromIsoString(func_get_args());

        $duration = Iso8601::parseDuration($isoString);

        return new self(
            $duration['years'],
            $duration['months'],
            $duration['days'],
            $duration['hours'],
            $duration['minutes'],
            $duration['seconds']
        );
    }

    /**
     * @param DateInterval $dateInterval The native PHP DateInterval.
     *
     * @return Period The Period constructed from the native PHP DateInterval.
     */
    public static function fromNativeDateInterval(DateInterval $dateInterval)
    {
        TypeCheck::get(__CLASS__)->fromNativeDateInterval(func_get_args());

        $period = new self(
            $dateInterval->y,
            $dateInterval->m,
            $dateInterval->d,
            $dateInterval->h,
            $dateInterval->i,
            $dateInterval->s
        );

        if ($dateInterval->invert) {
            return $period->inverse();
        }

        return $period;
    }

    /**
     * @return integer The number of years in the period.
     */
    public function years()
    {
        $this->typeCheck->years(func_get_args());

        return $this->years;
    }

    /**
     * @return integer The number of months in the period.
     */
    public function months()
    {
        $this->typeCheck->months(func_get_args());

        return $this->months;
    }

    /**
     * @return integer The number of days in the period.
     */
    public function days()
    {
        $this->typeCheck->days(func_get_args());

        return $this->days;
    }

    /**
     * @return integer The number of hours in the period.
     */
    public function hours()
    {
        $this->typeCheck->hours(func_get_args());

        return $this->hours;
    }

    /**
     * @return integer The number of minutes in the period.
     */
    public function minutes()
    {
        $this->typeCheck->minutes(func_get_args());

        return $this->minutes;
    }

    /**
     * @return integer The number of seconds in the period.
     */
    public function seconds()
    {
        $this->typeCheck->seconds(func_get_args());

        return $this->seconds;
    }

    /**
     * @return integer The approximate total seconds in the period.
     */
    public function approximateTotalSeconds()
    {
        $this->typeCheck->approximateTotalSeconds(func_get_args());

        return Calendar::approximateTotalSeconds(
            $this->years(),
            $this->months(),
            0,
            $this->days(),
            $this->hours(),
            $this->minutes(),
            $this->seconds()
        );
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

        return $value instanceof Period;
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
     * @param mixed $period The period to compare.
     *
     * @return integer                0 if $this and $period are equal, <0 if $this < $period, or >0 if $this > $period.
     * @throws NotComparableException Indicates that the implementation does not know how to compare $this to $period.
     */
    public function compare($period)
    {
        $this->typeCheck->compare(func_get_args());

        if (!$this->canCompare($period)) {
            throw new NotComparableException($this, $period);
        }

        return $this->years() - $period->years()
            ?: $this->months() - $period->months()
            ?: $this->days() - $period->days()
            ?: $this->hours() - $period->hours()
            ?: $this->minutes() - $period->minutes()
            ?: $this->seconds() - $period->seconds();
    }

    /**
     * @return boolean True if the period is zero seconds in length; otherwise, false.
     */
    public function isEmpty()
    {
        $this->typeCheck->isEmpty(func_get_args());

        return 0 === $this->years()
            && 0 === $this->months()
            && 0 === $this->days()
            && 0 === $this->hours()
            && 0 === $this->minutes()
            && 0 === $this->seconds();
    }

    /**
     * @return TimeSpanInterface
     */
    public function inverse()
    {
        $this->typeCheck->inverse(func_get_args());

        return new self(
            -$this->years(),
            -$this->months(),
            -$this->days(),
            -$this->hours(),
            -$this->minutes(),
            -$this->seconds()
        );
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

        return $this->resolveToTimePoint($timePoint)->differenceAsSeconds($timePoint);
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

        return $this->resolveToTimePoint($timePoint)->differenceAsDuration($timePoint);
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

        return $this;
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
            $timePoint->year() + $this->years(),
            $timePoint->month() + $this->months(),
            $timePoint->day() + $this->days(),
            $timePoint->hour() + $this->hours(),
            $timePoint->minute() + $this->minutes(),
            $timePoint->second() + $this->seconds(),
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

        if ($this->years()) {
            $chunks[] = $this->years() . 'y';
        }

        if ($this->months()) {
            $chunks[] = $this->months() . 'm';
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
            $this->years(),
            $this->months(),
            $this->days(),
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
    private $years;
    private $months;
    private $days;
    private $hours;
    private $minutes;
    private $seconds;
}
