<?php
namespace Icecave\Chrono\TypeCheck\Validator\Icecave\Chrono\Clock;

class AbstractClockTypeCheck extends \Icecave\Chrono\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function localTime(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function localDateTime(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function localDate(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function localMonth(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function localYear(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function utcTime(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function utcDateTime(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function utcDate(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function utcMonth(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function utcYear(array $arguments)
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

    public function suspend(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function resume(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function isSuspended(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function localTimeInfo(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function utcTimeInfo(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function currentLocalTimeInfo(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function currentUtcTimeInfo(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Chrono\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

}
