<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Support;

class Iso8601TypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function formatDate(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('year', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('month', 1, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('day', 2, 'integer');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'year',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'month',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'day',
                2,
                $arguments[2],
                'integer'
            );
        }
    }

    public function formatTime(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 4) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('hour', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('minute', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('second', 2, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('timeZone', 3, 'string');
        } elseif ($argumentCount > 4) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(4, $arguments[4]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'hour',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minute',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'second',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'timeZone',
                3,
                $arguments[3],
                'string'
            );
        }
    }

    public function formatDateTime(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 7) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('year', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('month', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('day', 2, 'integer');
            }
            if ($argumentCount < 4) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('hour', 3, 'integer');
            }
            if ($argumentCount < 5) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('minute', 4, 'integer');
            }
            if ($argumentCount < 6) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('second', 5, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('timeZone', 6, 'string');
        } elseif ($argumentCount > 7) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(7, $arguments[7]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'year',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'month',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'day',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'hour',
                3,
                $arguments[3],
                'integer'
            );
        }
        $value = $arguments[4];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minute',
                4,
                $arguments[4],
                'integer'
            );
        }
        $value = $arguments[5];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'second',
                5,
                $arguments[5],
                'integer'
            );
        }
        $value = $arguments[6];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'timeZone',
                6,
                $arguments[6],
                'string'
            );
        }
    }

    public function formatTimeZone(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('offset', 0, 'integer');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'offset',
                0,
                $arguments[0],
                'integer'
            );
        }
        if ($argumentCount > 1) {
            $value = $arguments[1];
            if (!\is_bool($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'useZForUTC',
                    1,
                    $arguments[1],
                    'boolean'
                );
            }
        }
    }

    public function formatDuration(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 6) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('years', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('months', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('days', 2, 'integer');
            }
            if ($argumentCount < 4) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('hours', 3, 'integer');
            }
            if ($argumentCount < 5) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('minutes', 4, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('seconds', 5, 'integer');
        } elseif ($argumentCount > 6) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(6, $arguments[6]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'years',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'months',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'days',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'hours',
                3,
                $arguments[3],
                'integer'
            );
        }
        $value = $arguments[4];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minutes',
                4,
                $arguments[4],
                'integer'
            );
        }
        $value = $arguments[5];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'seconds',
                5,
                $arguments[5],
                'integer'
            );
        }
    }

    public function formatIntervalDateTimes(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startDateTime', 0, 'string');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('endDateTime', 1, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startDateTime',
                0,
                $arguments[0],
                'string'
            );
        }
        $value = $arguments[1];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endDateTime',
                1,
                $arguments[1],
                'string'
            );
        }
    }

    public function formatIntervalDateTimeParts(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 14) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startYear', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startMonth', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startDay', 2, 'integer');
            }
            if ($argumentCount < 4) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startHour', 3, 'integer');
            }
            if ($argumentCount < 5) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startMinute', 4, 'integer');
            }
            if ($argumentCount < 6) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startSecond', 5, 'integer');
            }
            if ($argumentCount < 7) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startTimeZone', 6, 'string');
            }
            if ($argumentCount < 8) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('endYear', 7, 'integer');
            }
            if ($argumentCount < 9) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('endMonth', 8, 'integer');
            }
            if ($argumentCount < 10) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('endDay', 9, 'integer');
            }
            if ($argumentCount < 11) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('endHour', 10, 'integer');
            }
            if ($argumentCount < 12) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('endMinute', 11, 'integer');
            }
            if ($argumentCount < 13) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('endSecond', 12, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('endTimeZone', 13, 'string');
        } elseif ($argumentCount > 14) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(14, $arguments[14]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startYear',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startMonth',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startDay',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startHour',
                3,
                $arguments[3],
                'integer'
            );
        }
        $value = $arguments[4];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startMinute',
                4,
                $arguments[4],
                'integer'
            );
        }
        $value = $arguments[5];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startSecond',
                5,
                $arguments[5],
                'integer'
            );
        }
        $value = $arguments[6];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startTimeZone',
                6,
                $arguments[6],
                'string'
            );
        }
        $value = $arguments[7];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endYear',
                7,
                $arguments[7],
                'integer'
            );
        }
        $value = $arguments[8];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endMonth',
                8,
                $arguments[8],
                'integer'
            );
        }
        $value = $arguments[9];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endDay',
                9,
                $arguments[9],
                'integer'
            );
        }
        $value = $arguments[10];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endHour',
                10,
                $arguments[10],
                'integer'
            );
        }
        $value = $arguments[11];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endMinute',
                11,
                $arguments[11],
                'integer'
            );
        }
        $value = $arguments[12];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endSecond',
                12,
                $arguments[12],
                'integer'
            );
        }
        $value = $arguments[13];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'endTimeZone',
                13,
                $arguments[13],
                'string'
            );
        }
    }

    public function formatIntervalDateTimeAndDuration(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startDateTime', 0, 'string');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('duration', 1, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startDateTime',
                0,
                $arguments[0],
                'string'
            );
        }
        $value = $arguments[1];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'duration',
                1,
                $arguments[1],
                'string'
            );
        }
    }

    public function formatIntervalDateTimePartsAndDuration(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 8) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startYear', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startMonth', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startDay', 2, 'integer');
            }
            if ($argumentCount < 4) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startHour', 3, 'integer');
            }
            if ($argumentCount < 5) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startMinute', 4, 'integer');
            }
            if ($argumentCount < 6) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startSecond', 5, 'integer');
            }
            if ($argumentCount < 7) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startTimeZone', 6, 'string');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('duration', 7, 'string');
        } elseif ($argumentCount > 8) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(8, $arguments[8]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startYear',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startMonth',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startDay',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startHour',
                3,
                $arguments[3],
                'integer'
            );
        }
        $value = $arguments[4];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startMinute',
                4,
                $arguments[4],
                'integer'
            );
        }
        $value = $arguments[5];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startSecond',
                5,
                $arguments[5],
                'integer'
            );
        }
        $value = $arguments[6];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startTimeZone',
                6,
                $arguments[6],
                'string'
            );
        }
        $value = $arguments[7];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'duration',
                7,
                $arguments[7],
                'string'
            );
        }
    }

    public function formatIntervalDateTimeAndDurationParts(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 7) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startDateTime', 0, 'string');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationYears', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationMonths', 2, 'integer');
            }
            if ($argumentCount < 4) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationDays', 3, 'integer');
            }
            if ($argumentCount < 5) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationHours', 4, 'integer');
            }
            if ($argumentCount < 6) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationMinutes', 5, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationSeconds', 6, 'integer');
        } elseif ($argumentCount > 7) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(7, $arguments[7]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startDateTime',
                0,
                $arguments[0],
                'string'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationYears',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationMonths',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationDays',
                3,
                $arguments[3],
                'integer'
            );
        }
        $value = $arguments[4];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationHours',
                4,
                $arguments[4],
                'integer'
            );
        }
        $value = $arguments[5];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationMinutes',
                5,
                $arguments[5],
                'integer'
            );
        }
        $value = $arguments[6];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationSeconds',
                6,
                $arguments[6],
                'integer'
            );
        }
    }

    public function formatIntervalDateTimePartsAndDurationParts(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 13) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startYear', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startMonth', 1, 'integer');
            }
            if ($argumentCount < 3) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startDay', 2, 'integer');
            }
            if ($argumentCount < 4) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startHour', 3, 'integer');
            }
            if ($argumentCount < 5) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startMinute', 4, 'integer');
            }
            if ($argumentCount < 6) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startSecond', 5, 'integer');
            }
            if ($argumentCount < 7) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('startTimeZone', 6, 'string');
            }
            if ($argumentCount < 8) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationYears', 7, 'integer');
            }
            if ($argumentCount < 9) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationMonths', 8, 'integer');
            }
            if ($argumentCount < 10) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationDays', 9, 'integer');
            }
            if ($argumentCount < 11) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationHours', 10, 'integer');
            }
            if ($argumentCount < 12) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationMinutes', 11, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('durationSeconds', 12, 'integer');
        } elseif ($argumentCount > 13) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(13, $arguments[13]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startYear',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startMonth',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startDay',
                2,
                $arguments[2],
                'integer'
            );
        }
        $value = $arguments[3];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startHour',
                3,
                $arguments[3],
                'integer'
            );
        }
        $value = $arguments[4];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startMinute',
                4,
                $arguments[4],
                'integer'
            );
        }
        $value = $arguments[5];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startSecond',
                5,
                $arguments[5],
                'integer'
            );
        }
        $value = $arguments[6];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'startTimeZone',
                6,
                $arguments[6],
                'string'
            );
        }
        $value = $arguments[7];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationYears',
                7,
                $arguments[7],
                'integer'
            );
        }
        $value = $arguments[8];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationMonths',
                8,
                $arguments[8],
                'integer'
            );
        }
        $value = $arguments[9];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationDays',
                9,
                $arguments[9],
                'integer'
            );
        }
        $value = $arguments[10];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationHours',
                10,
                $arguments[10],
                'integer'
            );
        }
        $value = $arguments[11];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationMinutes',
                11,
                $arguments[11],
                'integer'
            );
        }
        $value = $arguments[12];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'durationSeconds',
                12,
                $arguments[12],
                'integer'
            );
        }
    }

    public function parseDate(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('isoString', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'isoString',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function parseTime(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('isoString', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'isoString',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function parseDateTime(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('isoString', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'isoString',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function parseTimeZone(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('isoString', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'isoString',
                0,
                $arguments[0],
                'string'
            );
        }
    }

    public function parseDuration(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('isoString', 0, 'string');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'isoString',
                0,
                $arguments[0],
                'string'
            );
        }
    }

}
