<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono;

class DateTimeTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
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

}
