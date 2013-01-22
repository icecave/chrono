<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono;

class TimeTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 4) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(4, $arguments[4]);
        }
        if ($argumentCount > 0) {
            $value = $arguments[0];
            if (!\is_int($value)) {
                throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'hours',
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
                    'minutes',
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
                    'seconds',
                    2,
                    $arguments[2],
                    'integer'
                );
            }
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

    public function timeZone(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function compare(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('time', 0, 'Icecave\\Chrono\\Time');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function isoString(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function validateToString(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}
