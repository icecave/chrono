<?php
namespace Icecave\Chrono;

class DateTime
{
    const FORMAT_ATOM    = 'Y-m-d\TH:i:sP';
    const FORMAT_COOKIE  = 'l, d-M-y H:i:s T';
    const FORMAT_ISO8601 = 'Y-m-d\TH:i:sO';
    const FORMAT_RFC822  = 'D, d M y H:i:s O';
    const FORMAT_RFC850  = 'l, d-M-y H:i:s T';
    const FORMAT_RFC1036 = 'D, d M y H:i:s O';
    const FORMAT_RFC1123 = 'D, d M Y H:i:s O';
    const FORMAT_RFC2822 = 'D, d M Y H:i:s O';
    const FORMAT_RFC3339 = 'Y-m-d\TH:i:sP';
    const FORMAT_RSS     = 'D, d M Y H:i:s O';
    const FORMAT_W3C     = 'Y-m-d\TH:i:sP';
}
