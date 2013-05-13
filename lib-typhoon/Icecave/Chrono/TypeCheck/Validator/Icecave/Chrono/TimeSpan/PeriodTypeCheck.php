<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\TimeSpan;

class PeriodTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 6) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(6, $arguments[6]);
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
                    'days',
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
                    'hours',
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
                    'minutes',
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
                    'seconds',
                    5,
                    $arguments[5],
                    'integer'
                );
            }
        }
    }

    public function years(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function months(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function days(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function hours(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function minutes(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function seconds(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function resolve(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('timePoint', 0, 'Icecave\\Chrono\\TimePointInterface');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

}
