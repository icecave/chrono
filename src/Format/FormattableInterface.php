<?php

namespace Icecave\Chrono\Format;

/**
 * Interface for objects that can be formatted by a formatter.
 */
interface FormattableInterface
{
    /**
     * @param string                  $formatSpecifier The format of the output string.
     * @param FormatterInterface|null $formatter       The formatter to use, or null to use the default.
     *
     * @return string The formatted string.
     */
    public function format($formatSpecifier, FormatterInterface $formatter = null);
}
