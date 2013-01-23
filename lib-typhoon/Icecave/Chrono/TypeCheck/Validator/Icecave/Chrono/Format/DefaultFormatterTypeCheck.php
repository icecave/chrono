<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Format;

class DefaultFormatterTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function formatDate(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('date', 0, 'Icecave\\Chrono\\Date');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('formatSpecifier', 1, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'formatSpecifier',
                1,
                $arguments[1],
                'string'
            );
        }
    }

    public function formatTime(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('Time', 0, 'Icecave\\Chrono\\Time');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('formatSpecifier', 1, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'formatSpecifier',
                1,
                $arguments[1],
                'string'
            );
        }
    }

    public function formatDateTime(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('dateTime', 0, 'Icecave\\Chrono\\DateTime');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('formatSpecifier', 1, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'formatSpecifier',
                1,
                $arguments[1],
                'string'
            );
        }
    }

    public function formatTimeZone(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('timeZone', 0, 'Icecave\\Chrono\\TimeZone');
            }
            throw new \Icecave\Chrono\TypeCheck\Exception\MissingArgumentException('formatSpecifier', 1, 'string');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        if (!\is_string($value)) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentValueException(
                'formatSpecifier',
                1,
                $arguments[1],
                'string'
            );
        }
    }

    public function instance(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}