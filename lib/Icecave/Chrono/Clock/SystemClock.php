<?php
// namespace Icecave\Chrono\Clock;
// 
// use Icecave\Isolator\Isolator;
// 
// class SystemClock extends AbstractClock
// {
//     /**
//      * @param Isolator|null $isolator
//      */
//     public function __construct(Isolator $isolator = null)
//     {
//         $this->isolator = Isolator::get($isolator);
//     }
// 
//     /**
//      * @return TimeZone The local timezone.
//      */
//     public function timeZone()
//     {
//         list($seconds, $minutes, $hours, $day, $month, $year, $weekDay, $yearDay, $isDst) = $this->localTimeInfo();
//         $offset = $this->isolator->date('Z', $this->unixTime());
// 
//         return new TimeZone($offset, $isDst ? true : false);
//     }
// 
//     /**
//      * @return integer The current time as a unix timestamp.
//      */
//     public function unixTime()
//     {
//         return $this->isolator->time();
//     }
// 
//     /**
//      * @return array<integer> A tuple containing time information, as per {@see localtime()}.
//      */
//     protected function localTimeInfo()
//     {
//         return $this->isolator->localtime($this->unixTime());
//     }
// 
//     /**
//      * @return array<integer> A tuple containing time information, as per {@see localtime()}, but for the UTC timezone.
//      */
//     protected function utcTimeInfo()
//     {
//         $parts   = $this->isolator->gmdate('s,i,H,d,m,Y,w,z', $this->unixTime());
//         $parts   = explode(',', $parts);
//         $parts   = array_map('intval', $parts);
//         $parts[] = 0; // isDst
// 
//         return $parts;
//     }
// 
//     private $isolator;
// }
