# Chrono Changelog

### 0.2.0 (2013-05-13)

* **[BC]** Moved `Duration` and `TimeSpanInterface` into `TimeSpan` namespace
* **[BC]** Removed `AbstractDuration` and `DurationInterface`
* **[BC]** Renamed `TimeSpanInterface::resolve()` to `resolveToSeconds()`
* **[IMPROVED]** `TimePointInterface::add()` and `subtract()` now accept raw seconds as integer, as well as a time span
* **[FIXED]** Added missing time zone support to `Date::fromNativeDateTime()` and `nativeDateTime()`
* **[NEW]** Implemented `Period`, a model of `TimeSpanInterface`
* **[NEW]** Added `TimeSpanInterface::inverse()`, `isEmpty()`, `resolveTo[Duration/Period/Interval/TimePoint]()`
* **[NEW]** Added `TimePointInterface::differenceAsSeconds()` and `differenceAsPeriod()`
* **[NEW]** Added `is[Not]EqualTo()` and `is[Less/Greater]Than[OrEqualTo]()` to all types with `compare()`
* **[NEW]** Added `Year::fromTimePoint()` and `Month::fromTimePoint()`

### 0.1.1 (2013-05-09)

* **[FIXED]** Fixed inverted comparison of time zone in `DateTime/Date/TimeOfDay::compare()`

### 0.1.0 (2013-05-06)

* Initial release
