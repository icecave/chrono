# Chrono Changelog

### 1.0.4 (2016-02-19)

* **[IMPROVED]** Added support for partial second parsing in internal class `Iso8604`, in preparation for adding partial-second support to the public interface

### 1.0.3 (2015-02-16)

* **[IMPROVED]** `DateTime` and `TimeOfDay` ISO string parsing now allows (but discards) partial-second information

### 1.0.2 (2014-11-10)

* **[FIXED]** `DateTime::fromNativeDateTime()` correctly preserves DST flag when converting from timezones that use abbreviated names (e.g. PST, PDT, etc)

### 1.0.1 (2014-10-20)

* **[IMPROVED]** Allow either version 2.* or 3.* of [icecave/isolator](https://github.com/isolator)

### 1.0.0 (2014-09-09)

* **[NEW]** Added convenience factory methods on `Duration`

### 0.4.0 (2014-02-27)

* **[NEW]** Added `TestClock`, a clock implementation that can be manipulated manually to ease testing of time-dependent code
* **[IMPROVED]** Updated autoloader to [PSR-4](http://www.php-fig.org/psr/psr-4/)

### 0.3.0 (2014-01-24)

* **[BC]** Methods names on `TimeInterface` are now singular (ie, `hour()` vs `hours()`)
* **[BC]** `Interval::isoStringWithDuration()` is now more correctly named `isoStringWithPeriod()`
* **[FIXED]** `SystemClock::unixTime()` now properly suspends when the clock is suspended
* **[IMPROVED]** `Period::resolveToInterval()` and `Duration::resolveToInterval()` can now handle negative time spans
* **[NEW]** Added ISO-8601 parsing to `Period`, `Interval`, `Year` and `Month`
* **[NEW]** Added `DateInterface::isoDayOfWeek()` and `numericDayOfWeek()`
* **[NEW]** Added methods for converting `Period` and `Duration` to/from PHP's `DateInterval` type
* **[NEW]** Added `ClockInterface::unixTimeAsFloat()`
* **[NEW]** Added `ClockInterface::sleep()` and `sleepUntil()`
* **[NEW]** Added `TimerInterface`, `Timer` and `ClockInterface::createTimer()`
* **[NEW]** Implemented several iterator types for iterating over time spans (see [#3](https://github.com/IcecaveStudios/chrono/issues/3))
* **[NEW]** Most objects can now be compared using [Parity](https://github.com/IcecaveStudios/parity)

### 0.2.0 (2013-05-13)

* **[BC]** Moved `Duration` and `TimeSpanInterface` into `TimeSpan` namespace
* **[BC]** Removed `AbstractDuration` and `DurationInterface`
* **[BC]** Renamed `TimeSpanInterface::resolve()` to `resolveToSeconds()`
* **[IMPROVED]** `TimePointInterface::add()` and `subtract()` now accept raw seconds as integer, as well as a time span
* **[FIXED]** Added missing time zone support to `Date::fromNativeDateTime()` and `nativeDateTime()`
* **[NEW]** Implemented `Period`, a model of `TimeSpanInterface`
* **[NEW]** Added `TimeSpanInterface::inverse()`, `isEmpty()`, `__toString()` and `resolveTo***()` methods
* **[NEW]** Added `TimePointInterface::differenceAsSeconds()` and `differenceAsPeriod()`
* **[NEW]** Added `is[Not]EqualTo()` and `is[Less/Greater]Than[OrEqualTo]()` to all types with `compare()`
* **[NEW]** Added `Year::fromTimePoint()` and `Month::fromTimePoint()`

### 0.1.1 (2013-05-09)

* **[FIXED]** Fixed inverted comparison of time zone in `DateTime/Date/TimeOfDay::compare()`

### 0.1.0 (2013-05-06)

* Initial release
