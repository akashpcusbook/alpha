<?php

namespace Tusker\Framework\Support;

/**
 * It is used to Perform Date related operations.
 */
class Date
{
    public static function now(): string
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * It is used to get todays date in 'Y-m-d' format.
     *
     * @return string
     */
    public static function today() : string
    {
        return date('Y-m-d');
    }
    
    /**
     * It is used to get yesterdays date in 'Y-m-d' format.
     *
     * @return string
     */
    public static function yesterday() : string 
    {
        return self::daysBefore(1) ;
    }

    /**
     * It is used to get tomorrows date in 'Y-m-d' format.
     *
     * @return string
     */
    public static function tomorrow() : string 
    {
        return self::daysAfter(1) ;
    }

    /**
     * It is used to get date after given no of days in 'Y-m-d' format.
     *
     * @param int $noOfDays
     * @return string
     */
    public static function daysAfter(int $noOfDays) : string 
    {
        return date('Y-m-d', strtotime('+'.$noOfDays.' days')) ;
    }

    /**
     * It is used to get date before given no of days in 'Y-m-d' format.
     *
     * @param int $noOfDays
     * @return string
     */
    public static function daysBefore(int $noOfDays) : string 
    {
        return date('Y-m-d', strtotime('-'.$noOfDays.' days')) ;
    }

    /**
     * It is used to get date after given no of months in 'Y-m-d' format.
     *
     * @param integer $noOfMonths
     * @return string
     */
    public static function monthsAfter(int $noOfMonths) : string 
    {
        return  date('Y-m-d', strtotime('+'.$noOfMonths.' months')) ;
    }

    /**
     * It is used to get date before given no of months in 'Y-m-d' format.
     *
     * @param integer $noOfMonths
     * @return string
     */
    public static function monthsBefore(int $noOfMonths) : string 
    {
        return  date('Y-m-d', strtotime('-'.$noOfMonths.' months')) ;
    }

    public static function yearsAfter(int $noOfYears) : string 
    {
        return  date('Y-m-d', strtotime('+'.$noOfYears.' years')) ;
    }

    public static function yearsBefore(int $noOfYears) : string 
    {
        return  date('Y-m-d', strtotime('-'.$noOfYears.' years')) ;
    }

    /**
     * It returns current time in 'H:i:s' format.
     *
     * @return string
     */
    public static function timeNow() : string 
    {
        return date('H:i:s') ;
    }

    /**
     * It returns default timezone. 
     *
     * @return string
     */
    public static function getTimeZone() : string
    {
        return \date_default_timezone_get();
    }

    /**
     * It allows to set timezone.
     *
     * @param string $timeZone
     * @return boolean
     * @see https://www.php.net/manual/en/timezones.php
     */
    public static function setTimeZone(string $timeZone) : bool 
    {
        return \date_default_timezone_set($timeZone) ;
    }

    /**
     * It is used to format date from a date string.
     *
     * @param string $format
     * @param string $date
     * @return string
     * @see https://www.php.net/manual/en/datetime.format.php
     */
    public static function format(string $format = 'Y-m-d H:i:s', string $date = null) : string
    {
        return (!empty($date)) ? date($format, strtotime($date)) : date($format, time()) ;
    }

    /**
     * It allows to convert date string to unix type date.
     * If no date string provided then it will return current date in unix format.
     *
     * @param string $date
     * @return integer
     */
    public static function toUnix(string $date = null) : int
    {
        return empty($date) ? time() : (int)strtotime($date) ;
    }

    /**
     * It allows to convert unix format to date string and return date string in 'Y-m-d' format.
     *
     * @param integer $unix
     * @return string
     */
    public static function unixToDate(int $unix) : string 
    {
        return date('Y-m-d', $unix) ;
    }

    /**
     * It allows to convert unix format to date time string and return date time string in 'Y-m-d H:i:s' format.
     *
     * @param integer $unix
     * @return string
     */
    public static function unixToDateTime(int $unix) : string 
    {
        return date('Y-m-d H:i:s', $unix) ;
    }

    /**
     * It allows to get time and date interval between dates or times. Default value returns in seconds.
     * If invert is set to true and dateTo is less then dateFrom then result will be negative value else positive value.
     * Below are the interval formats: 
     * y = years,
     * m = months,
     * d = days,
     * h = hours,
     * i = minutes,
     * s = seconds
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $interval
     * @param boolean $invert
     * @return integer
     */
    public static function diff(string $dateFrom, string $dateTo, string $interval = 's', bool $invert = false) : int
    {  
        $diff = date_diff(date_create($dateFrom), date_create($dateTo));
        $total = 0;

        switch($interval)
        {
            case "y":
                $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; 
                break;
            case "m":
                $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
                break;
            case "d":
                $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
                break;
            case "h":
                $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
                break;
            case "i":
                $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
                break;
            case "s":
                $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
                break;
        }

        $total = (int)$total ;

        if($invert) {
            if( $diff->invert) return -1 * $total;
            else return $total;
        }

        return $total ;
    }

    /**
     * It returns a formated string based on the format text of difference between dates or times.
     * Below are the formats: 
     * %y = Years,
     * %m = Months,
     * %d = Days,
     * %h = Hours,
     * %i = Minutes,
     * %s = Seconds,
     * %a = Total Calculated Days
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $formatText
     * @return string
     */
    public static function diffFormat(string $dateFrom, string $dateTo, string $formatText = '%a Days') : string 
    {
        $interval = date_diff(date_create($dateFrom), date_create($dateTo));

        return $interval->format($formatText);
    }

    /**
     * It returns first day of week
     *
     * @return string
     */
    public static function weekStart() : string 
    {
        return date("Y-m-d H:i:s", (strtotime("next Monday") - 604800)) ;
    }

    /**
     * It returns last day of week
     *
     * @return string
     */
    public static function weekEnd() : string 
    {
        return date("Y-m-d H:i:s", (strtotime("next Monday") - 86400)) ;
    }

    /**
     * It returns week of month by a specific date if provided else returns current week of month
     *
     * @param string $date
     * @return integer
     */
    public static function weekOfMonth(string $date = '') : int
    {
        if(empty($date)) $date = time();
        else $date = strtotime($date); 
        
        //Week of the month = Week of the year - Week of the year of first day of month + 1

        return self::weekOfYear(date("Y-m-d", $date)) - self::weekOfYear(date("Y-m-01", $date)) + 1;
    }
    
    /**
     * It returns week of year by a specific date if provided else returns current week of year
     *
     * @param string $date
     * @return integer
     */
    public static function weekOfYear(string $date = '') : int
    {
        if(empty($date)) $date = time();
        else $date = strtotime($date);
        
        $weekOfYear = intval(date("W", $date));
        if (date('n', $date) == "1" && $weekOfYear > 51) {
            // It's the last week of the previos year.
            $weekOfYear = 0;    
        }

        return $weekOfYear;
    }

    public static function noOfDaysInMonth(string $date = null) : int
    {
        if(empty($date)) $date = time();
        else $date = strtotime($date);

        return (int)date('t', $date) ;
    }
}
