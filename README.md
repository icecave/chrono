# Chrono

[![Build Status](https://secure.travis-ci.org/IcecaveStudios/chrono.png)](http://travis-ci.org/IcecaveStudios/chrono)
[![Test Coverage](http://icecavestudios.github.com/chrono/coverage-report/coverage.png)](http://icecavestudios.github.com/chrono/coverage-report/index.html)

**Chrono** is a set of PHP date and time abstractions that are decoupled from the system clock.

## Installation

**Chrono** requires PHP 5.3.3 or newer.

### With [Composer](http://getcomposer.org/)

* Add 'icecave/chrono' to the project's composer.json dependencies
* Run `php composer.phar install`

### Bare installation

* Clone from GitHub: `git clone git://github.com/IcecaveStudios/chrono.git`
* Use a [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
  compatible autoloader (namespace 'Icecave\Chrono' in the 'lib' directory)

## Concepts

* [Clock](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Clock/ClockInterface.php): A factory for chronological measurements.
* [Time](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/TimeInterface.php): A chronological measurement with a time component.
* [Date](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/DateInterface.php): A chronological measurement with a date component.
* [Time Point](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/TimePointInterface.php): A discreet point on the time-continuum.
* [Interval](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Interval/IntervalInterface.php): A span of time between two *Time Points*.
* **Duration**: A span of time measured in seconds, with no specified beginning or end.
* **Period**: A span of time specified in component form (eg: 3 months, 4 days).

## Implementations

* [System Clock](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Clock/SystemClock.php): A factory for chronological measurements that uses the system clock.
* [Date](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Date.php): Represents a date, models the *Time Point* and *Date* concepts.
* [Time of Day](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/TimeOfDay.php): Represents a time of day, models the *Time* concept.
* [Date Time](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/DateTime.php): Represents a time of day on specific date, models the *Time Point*, *Date* and *Time* concepts.
* [Interval](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Interval/Interval.php): A span of time between two *Time Points*, models the *Interval* concept.
* [Month](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Interval/Month.php): A one month time span, models the *Interval* concept.
* [Year](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Interval/Year.php): A one year time span, models the *Interval* concept.

## Examples

### Getting the current time

In order to get the current time you need to use a [clock](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Clock/ClockInterface.php). Most of the time in production code you will use the [SystemClock](/IcecaveStudios/chrono/blob/master/lib/Icecave/Chrono/Clock/SystemClock.php) class, which uses the machine's current system time and time zone information.

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

Each of the clock methods shown above has a [UTC](http://en.wikipedia.org/wiki/Coordinated_Universal_Time) counterpart. To obtain the current time in UTC you can use the following code:

```php
$nowUtc = $clock->utcDateTime();
```

