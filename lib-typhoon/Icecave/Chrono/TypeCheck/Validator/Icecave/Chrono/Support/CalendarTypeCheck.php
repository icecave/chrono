<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Support;

class CalendarTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function daysInYear(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('year', 0, 'integer');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
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
    }

    public function daysInMonth(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('year', 0, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('month', 1, 'integer');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
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
    }

    public function isLeapYear(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('year', 0, 'integer');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
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
    }

    public function monthName(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('month', 0, 'integer');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'month',
                0,
                $arguments[0],
                'integer'
            );
        }
    }

    public function monthAbbreviation(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('month', 0, 'integer');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'month',
                0,
                $arguments[0],
                'integer'
            );
        }
    }

    public function dayName(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('isoDay', 0, 'integer');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'isoDay',
                0,
                $arguments[0],
                'integer'
            );
        }
    }

    public function dayAbbreviation(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('isoDay', 0, 'integer');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'isoDay',
                0,
                $arguments[0],
                'integer'
            );
        }
    }

    public function dayOfYear(array $arguments)
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

    public function dayOfWeek(array $arguments)
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
        } elseif ($argumentCount > 4) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(4, $arguments[4]);
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
        if ($argumentCount > 3) {
            $value = $arguments[3];
            if (!\is_bool($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'iso',
                    3,
                    $arguments[3],
                    'boolean'
                );
            }
        }
    }

    public function isoWeekNumber(array $arguments)
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

    public function isoYearNumber(array $arguments)
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

    public function approximateTotalSeconds(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 7) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(7, $arguments[7]);
        }
        if ($argumentCount > 0) {
            $value = $arguments[0];
            if (!\is_int($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'years',
                    0,
                    $arguments[0],
                    'integer'
                );
            }
        }
        if ($argumentCount > 1) {
            $value = $arguments[1];
            if (!\is_int($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'months',
                    1,
                    $arguments[1],
                    'integer'
                );
            }
        }
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_int($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'weeks',
                    2,
                    $arguments[2],
                    'integer'
                );
            }
        }
        if ($argumentCount > 3) {
            $value = $arguments[3];
            if (!\is_int($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'days',
                    3,
                    $arguments[3],
                    'integer'
                );
            }
        }
        if ($argumentCount > 4) {
            $value = $arguments[4];
            if (!\is_int($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'hours',
                    4,
                    $arguments[4],
                    'integer'
                );
            }
        }
        if ($argumentCount > 5) {
            $value = $arguments[5];
            if (!\is_int($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'minutes',
                    5,
                    $arguments[5],
                    'integer'
                );
            }
        }
        if ($argumentCount > 6) {
            $value = $arguments[6];
            if (!\is_int($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'seconds',
                    6,
                    $arguments[6],
                    'integer'
                );
            }
        }
    }

}
