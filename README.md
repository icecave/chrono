# Chrono

[![Build Status]](https://travis-ci.org/IcecaveStudios/chrono)
[![Test Coverage]](https://coveralls.io/r/IcecaveStudios/chrono?branch=develop)
[![SemVer]](http://semver.org)

**Chrono** is a PHP date & time library that is decoupled from the system clock.

* Install via [Composer](http://getcomposer.org) package [icecave/chrono](https://packagist.org/packages/icecave/chrono)
* Read the [API documentation](http://icecavestudios.github.io/chrono/artifacts/documentation/api/)

## Rationale

Many date & time operations in the core PHP libraries require access to system state such as the current wall time, or
resources such as timezone databases. These hard-wired dependencies can make it very difficult to write well-abstracted
and testable code when dealing with time-sensitive operations.

**Chrono** provides a set of date & time classes that are completely decoupled from the system and hence behave
consistently, regardless of system state and configuration (such as the
[date.timezone INI directive](http://www.php.net/manual/en/datetime.configuration.php#ini.date.timezone)).

A [SystemClock](src/Clock/SystemClock.php) instance must be explicitly constructed before any global
date & time operations are used. Classes that require use of a clock may take a [ClockInterface](src/Clock/ClockInterface.php)
as a [dependency](http://en.wikipedia.org/wiki/Dependency_injection), improving decoupling and testability.

## Concepts

* [Clock](src/Clock/ClockInterface.php): A factory for chronological measurements.
* [Time](src/TimeInterface.php): A chronological measurement with a time component.
* [Date](src/DateInterface.php): A chronological measurement with a date component.
* [Time Point](src/TimePointInterface.php): A discreet point on the time-continuum.
* [Time Span](src/TimeSpan/TimeSpanInterface.php): An un-anchored span of time.
* [Interval](src/Interval/IntervalInterface.php): A span of time between two *Time Points*.

## Implementations

* [System Clock](src/Clock/SystemClock.php): A factory for chronological measurements that uses the system clock.
* [Test Clock](src/Clock/TestClock.php): A clock that can be manually manipulated for testing purposes.
* [Date](src/Date.php): Represents a date. Models the *Time Point* and *Date* concepts.
* [Time of Day](src/TimeOfDay.php): Represents a time of day. Models the *Time* concept.
* [Date Time](src/DateTime.php): Represents a time of day on specific date. Models the *Time Point*, *Date* and *Time* concepts.
* [Interval](src/Interval/Interval.php): A span of time between two *Time Points*. Models the *Interval* concept.
* [Month](src/Interval/Month.php): A one month time span. Models the *Interval* concept.
* [Year](src/Interval/Year.php): A one year time span. Models the *Interval* concept.
* [Duration](src/TimeSpan/Duration.php): A time span measured in seconds with no beginning or end. Models the *Time Span* concept.
* [Period](src/TimeSpan/Period.php): A time span specified in component form (eg: 3 months, 4 days), models the *Time Span* concept.

## Examples

### Getting the current time

In order to get the current time you need to use a [clock](src/Clock/ClockInterface.php). Most of the time in production
code you will use the [SystemClock](src/Clock/SystemClock.php) class, which uses the machine's current system time and
time zone information.

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

To produce a formatted string representing a [Date](src/Date.php), [DateTime](src/DateTime.php),
[TimeOfDay](src/TimeOfDay.php) or [TimeZone](src/TimeZone.php) instance use the `format()`
method.

The output is specified using the same format as PHP's [built-in date() function](http://php.net/manual/en/function.date.php).

```php
$now = $clock->localDateTime();
$string = $now->format('Y-m-d H:i:s');
```

Casting the object as a string (or calling `isoString()`) produces an [ISO-8601](http://en.wikipedia.org/wiki/ISO_8601)
string representation.

### Unix timestamps

[Date](src/Date.php) and [DateTime](src/DateTime.php) instances can be produced from unix
timestamps using the `fromUnixTime()` static method. The unix timestamp can be retrieved using `unixTime()`.

```php
$dateTime = DateTime::fromUnixTime(1367823963);
$timestamp = $dateTime->unixTime();
```

### PHP native "DateTime" objects

[Date](src/Date.php) and [DateTime](src/DateTime.php) instances can be produced from
native PHP [DateTime](http://php.net/manual/en/class.datetime.php) instances using the `fromNativeDateTime()` static
method, and can be converted to a native DateTime using `nativeDateTime()`.

```php
use DateTime as NativeDateTime;
use Icecave\Chrono\DateTime;

$dateTime = DateTime::fromNativeDateTime(new NativeDateTime);
$nativeDateTime = $dateTime->nativeDateTime();
```

## Contact us

* Follow [@IcecaveStudios](https://twitter.com/IcecaveStudios) on Twitter
* Visit the [Icecave Studios website](http://icecave.com.au)
* Join `#icecave` on [irc.freenode.net](http://webchat.freenode.net?channels=icecave)

<!-- references -->
[Build Status]: http://img.shields.io/travis/IcecaveStudios/chrono/develop.svg?style=flat-square
[Test Coverage]: http://img.shields.io/coveralls/IcecaveStudios/chrono/develop.svg?style=flat-square
[SemVer]: http://img.shields.io/:semver-1.0.4-brightgreen.svg?style=flat-square
