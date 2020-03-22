<?php

/** Date utils */
class UtilsDate
{

    // Week day constants
    const MONDAY = 'MONDAY';
    const TUESDAY = 'TUESDAY';
    const WEDNESDAY = 'WEDNESDAY';
    const THURSDAY = 'THURSDAY';
    const FRIDAY = 'FRIDAY';
    const SATURDAY = 'SATURDAY';
    const SUNDAY = 'SUNDAY';

    // Month constants
    const JANUARY = 'JANUARY';
    const FEBRUARY = 'FEBRUARY';
    const MARCH = 'MARCH';
    const APRIL = 'APRIL';
    const MAY = 'MAY';
    const JUNE = 'JUNE';
    const JULY = 'JULY';
    const AUGUST = 'AUGUST';
    const SEPTEMBER = 'SEPTEMBER';
    const OCTOBER = 'OCTOBER';
    const NOVEMBER = 'NOVEMBER';
    const DECEMBER = 'DECEMBER';


    /**
     * Create a new date compatible with MySQL. If no date defined, it will return the current date
     *
     * @param string $year The custom year
     * @param number $month The custom month (1 to 12)
     * @param number $day The custom day
     * @param number $hour The custom hour
     * @param number $minute The custom minute
     * @param number $second The custom second
     *
     * @return string    The created mySQL date
     */
    public static function create($year = '', $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0)
    {
        if ($year == '') {
            return date('Y-m-d H:i:s');
        }

        $date = $year;
        $date .= '-' . UtilsFormatter::pad($month, 2, '0', 'LEFT');
        $date .= '-' . UtilsFormatter::pad($day, 2, '0', 'LEFT');
        $date .= ' ' . UtilsFormatter::pad($hour, 2, '0', 'LEFT');
        $date .= ':' . UtilsFormatter::pad($minute, 2, '0', 'LEFT');
        $date .= ':' . UtilsFormatter::pad($second, 2, '0', 'LEFT');

        return $date;
    }


    /**
     * Convert a date to its timestamp
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string   The timestamp
     */
    public static function toTimestamp($mysqlDate)
    {
        return date_format(date_create($mysqlDate), 'U');
    }


    /**
     * Check if a timestamp is valid or not
     *
     * @param int $timestamp The timestamp value
     *
     * @return bool
     */
    public static function isValidTimestamp($timestamp)
    {
        return intval($timestamp) != 0 && $timestamp <= PHP_INT_MAX && $timestamp >= ~PHP_INT_MAX;
    }


    /**
     * Convert a date to the format DD-MM-YYYY
     *
     * @param string $mysqlDate The mySQL date
     * @param string $glue The separator. "-" by default
     *
     * @return string    The formatted date
     */
    public static function toDDMMYYYY($mysqlDate, $glue = '-')
    {
        return date('d' . $glue . 'm' . $glue . 'Y', strtotime($mysqlDate));
    }


    /**
     * Convert a date to the format YYYY-MM-DD
     *
     * @param string $mysqlDate The mySQL date
     * @param string $glue The separator. "-" by default
     *
     * @return string    The formatted date
     */
    public static function toYYYYMMDD($mysqlDate, $glue = '-')
    {
        return date('Y' . $glue . 'm' . $glue . 'd', strtotime($mysqlDate));
    }


    /**
     * Convert a formatted date like DD-MM-YYYY to a mySQL compatible date. Hours, minutes and seconds will be defined as 0 by default
     *
     * @param string $date The formatted date
     * @param string $glue The separator used on the formatted date. "-" by default
     *
     * @return string    The mySQL date
     */
    public static function DDMMYYYYToDate($date, $glue = '-')
    {
        $date = explode($glue, $date);
        return self::create($date[2], $date[1], $date[0]);
    }


    /**
     * Convert a formatted date like YYYY-MM-DD to a mySQL compatible date. Hours, minutes and seconds will be defined as 0 by default
     *
     * @param string $date The formatted date
     * @param string $glue The separator used on the formatted date. "-" by default
     *
     * @return string    The mySQL date
     */
    public static function YYYYMMDDToDate($date, $glue = '-')
    {
        $date = explode($glue, $date);
        return self::create($date[0], $date[1], $date[2]);
    }


    /**
     * Add / substract on the current mySQL date
     *
     * @param string $period The period to be considered: YEAR, MONTH, DAY, HOUR, MINUTE, SECOND
     * @param string $mysqlDate The mySQL date
     * @param number $quantity The quantity of periods to add / substract. 1 by default
     * @param string $add Add or substract boolean. Add by default
     *
     * @return string The resulting mySQL date
     */
    public static function operate($period, $mysqlDate, $quantity = 1, $add = true)
    {
        return date('Y-m-d H:i:s', strtotime(($add ? '+' : '-') . intval($quantity) . $period, strtotime($mysqlDate)));
    }


    /**
     * Get the month name of a current mySQL date
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string
     */
    public static function getMonthName($mysqlDate)
    {
        switch (self::getMonth($mysqlDate)) {
            case 1:
                return self::JANUARY;
                break;
            case 2:
                return self::FEBRUARY;
                break;
            case 3:
                return self::MARCH;
                break;
            case 4:
                return self::APRIL;
                break;
            case 5:
                return self::MAY;
                break;
            case 6:
                return self::JUNE;
                break;
            case 7:
                return self::JULY;
                break;
            case 8:
                return self::AUGUST;
                break;
            case 9:
                return self::SEPTEMBER;
                break;
            case 10:
                return self::OCTOBER;
                break;
            case 11:
                return self::NOVEMBER;
                break;
            case 12:
                return self::DECEMBER;
                break;
        }
        return '';
    }


    /**
     * Get the week day name of a current mySQL date
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string
     */
    public static function getDayName($mysqlDate)
    {
        switch (date('w', strtotime($mysqlDate))) {
            case 0:
                return self::SUNDAY;
                break;
            case 1:
                return self::MONDAY;
                break;
            case 2:
                return self::TUESDAY;
                break;
            case 3:
                return self::WEDNESDAY;
                break;
            case 4:
                return self::THURSDAY;
                break;
            case 5:
                return self::FRIDAY;
                break;
            case 6:
                return self::SATURDAY;
                break;
        }
        return '';
    }


    /**
     * Get the year of a current mySQL date
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string
     */
    public static function getYear($mysqlDate)
    {
        $date = date_parse($mysqlDate);
        return $date['year'];
    }


    /**
     * Get the month of a current mySQL date. (from 1 to 12)
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string
     */
    public static function getMonth($mysqlDate)
    {
        $date = date_parse($mysqlDate);
        return $date['month'];
    }


    /**
     * Get the day of a current mySQL date
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string
     */
    public static function getDay($mysqlDate)
    {
        $date = date_parse($mysqlDate);
        return $date['day'];
    }


    /**
     * Get the hour of a current mySQL date
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string
     */
    public static function getHour($mysqlDate)
    {
        $date = date_parse($mysqlDate);
        return $date['hour'];
    }


    /**
     * Get the minute of a current mySQL date
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string
     */
    public static function getMinute($mysqlDate)
    {
        $date = date_parse($mysqlDate);
        return $date['minute'];
    }


    /**
     * Get the second of a current mySQL date
     *
     * @param string $mysqlDate The mySQL date
     *
     * @return string
     */
    public static function getSecond($mysqlDate)
    {
        $date = date_parse($mysqlDate);
        return $date['second'];
    }
}
