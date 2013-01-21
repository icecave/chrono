<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Support;

class NormalizerTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function normalizeTime(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('hours', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('minutes', 1, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('seconds', 2, 'integer');
        } elseif ($argumentCount > 4) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(4, $arguments[4]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'hours',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'minutes',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'seconds',
                2,
                $arguments[2],
                'integer'
            );
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
    }

    public function normalizeDate(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('year', 0, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('month', 1, 'integer');
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
        if ($argumentCount > 2) {
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
    }

    public function normalizeOverflow(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('value', 0, 'integer');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('min', 1, 'integer');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('max', 2, 'integer');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        $value = $arguments[0];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'value',
                0,
                $arguments[0],
                'integer'
            );
        }
        $value = $arguments[1];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'min',
                1,
                $arguments[1],
                'integer'
            );
        }
        $value = $arguments[2];
        if (!\is_int($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'max',
                2,
                $arguments[2],
                'integer'
            );
        }
    }

}
