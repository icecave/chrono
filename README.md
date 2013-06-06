# Chrono

[![Build Status]](http://travis-ci.org/IcecaveStudios/chrono)
[![Test Coverage]](http://icecavestudios.github.io/chrono/artifacts/tests/coverage)

**Chrono** is a PHP date & time library that is decoupled from the system clock.

Many date & time operations in the core PHP libraries require access to system resources such as the current wall time
and timezone databases. **Chrono** provides a set of date & time classes that are completely decoupled from the system
and hence behave consistently regardless of system settings (such as the
[date.timezone INI directive](http://www.php.net/manual/en/datetime.configuration.php#ini.date.timezone)).

A [SystemClock](lib/Icecave/Chrono/Clock/SystemClock.php) instance must be explicitly constructed before any global
date & time operations are used. Classes that require use of a clock may take a [ClockInterface](lib/Icecave/Chrono/Clock/ClockInterface.php)
as a [dependency](http://en.wikipedia.org/wiki/Dependency_injection), improving decoupling and testability of code that
makes use of date & time operations.

* Install via [Composer](http://getcomposer.org) package [icecave/chrono](https://packagist.org/packages/icecave/chrono)
* Read the [API documentation](http://icecavestudios.github.io/chrono/artifacts/documentation/api/)

## Concepts

* [Clock](lib/Icecave/Chrono/Clock/ClockInterface.php): A factory for chronological measurements.
* [Time](lib/Icecave/Chrono/TimeInterface.php): A chronological measurement with a time component.
* [Date](lib/Icecave/Chrono/DateInterface.php): A chronological measurement with a date component.
* [Time Point](lib/Icecave/Chrono/TimePointInterface.php): A discreet point on the time-continuum.
* [Time Span](lib/Icecave/Chrono/TimeSpan/TimeSpanInterface.php): An un-anchored span of time.
* [Interval](lib/Icecave/Chrono/Interval/IntervalInterface.php): A span of time between two *Time Points*.

## Implementations

* [System Clock](lib/Icecave/Chrono/Clock/SystemClock.php): A factory for chronological measurements that uses the system clock.
* [Date](lib/Icecave/Chrono/Date.php): Represents a date, models the *Time Point* and *Date* concepts.
* [Time of Day](lib/Icecave/Chrono/TimeOfDay.php): Represents a time of day, models the *Time* concept.
* [Date Time](lib/Icecave/Chrono/DateTime.php): Represents a time of day on specific date, models the *Time Point*, *Date* and *Time* concepts.
* [Interval](lib/Icecave/Chrono/Interval/Interval.php): A span of time between two *Time Points*, models the *Interval* concept.
* [Month](lib/Icecave/Chrono/Interval/Month.php): A one month time span, models the *Interval* concept.
* [Year](lib/Icecave/Chrono/Interval/Year.php): A one year time span, models the *Interval* concept.
* [Duration](lib/Icecave/Chrono/TimeSpan/Duration.php): A span of time measured in seconds, with no specified beginning or end, models the *Time Span* concept.
* [Period](lib/Icecave/Chrono/TimeSpan/Period.php): A span of time specified in component form (eg: 3 months, 4 days), models the *Time Span* concept.

## Examples

### Getting the current time

In order to get the current time you need to use a [clock](lib/Icecave/Chrono/Clock/ClockInterface.php).
Most of the time in production code you will use the [SystemClock](lib/Icecave/Chrono/Clock/SystemClock.php) class,
which uses the machine's current system time and time zone information.

```php
use Icecave\Chrono\Clock\SystemClock;

// Construct a new system clock ...
$clock = new SystemClock;

// Obtain a DateTime instance representing the current date and time ...
$now = $clock->localDateTime();

// Obtain a Date instance representing the current date ...
$today = $clock->localDate();

// Obtain the current time of day ...
$timeOfDay = $clock->localTime();
```

Each of the clock methods shown above has a [UTC](http://en.wikipedia.org/wiki/Coordinated_Universal_Time) counterpart.
For example, to obtain the current time in UTC you can use the following code:

```php
$nowUtc = $clock->utcDateTime();
```

### String formatting

To produce a formatted string representing a [Date](lib/Icecave/Chrono/Date.php), [DateTime](lib/Icecave/Chrono/DateTime.php),
[TimeOfDay](lib/Icecave/Chrono/TimeOfDay.php) or [TimeZone](lib/Icecave/Chrono/TimeZone.php) instance use the `format()` method.

The output is specified using the same format as PHP's [built-in date() function](http://php.net/manual/en/function.date.php).

```php
$now = $clock->localDateTime();
$string = $now->format('Y-m-d H:i:s');
```

Casting the object as a string (or calling `isoString()`) produces an [ISO-8601](http://en.wikipedia.org/wiki/ISO_8601) string representation.

### Unix timestamps

[Date](lib/Icecave/Chrono/Date.php) and [DateTime](lib/Icecave/Chrono/DateTime.php) instances can be produced from unix timestamps
using the `fromUnixTime()` static method. The unix timestamp can be retreived using `unixTime()`.

```php
$dateTime = DateTime::fromUnixTime(1367823963);
$timestamp = $dateTime->unixTime();
```

### PHP native "DateTime" objects

[Date](lib/Icecave/Chrono/Date.php) and [DateTime](lib/Icecave/Chrono/DateTime.php) instances can be produced from native PHP
[DateTime](http://php.net/manual/en/class.datetime.php) instances using the `fromNativeDateTime()` static method, and can be
converted to a native DateTime using `nativeDateTime()`.

```php
use DateTime as NativeDateTime;
use Icecave\Chrono\DateTime;

$dateTime = DateTime::fromNativeDateTime(new NativeDateTime);
$nativeDateTime = $dateTime->nativeDateTime();
```

<!-- references -->
[Build Status]: https://raw.github.com/IcecaveStudios/chrono/gh-pages/artifacts/images/icecave/regular/build-status.png
[Test Coverage]: https://raw.github.com/IcecaveStudios/chrono/gh-pages/artifacts/images/icecave/regular/coverage.png
