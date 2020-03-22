<?php

/**
 * String utilities
 */
class UtilsUnits
{

    /**
     * Convert bytes to kilobytes
     *
     * @param float $bytes The bytes quantity
     *
     * @return float The converted unit
     */
    public static function bytesToKilobytes($bytes)
    {
        return UtilsFormatter::setDecimals($bytes / 1024, 2);
    }


    /**
     * Convert bytes to megabytes
     *
     * @param float $bytes The bytes quantity
     *
     * @return float The converted unit
     */
    public static function bytesToMegabytes($bytes)
    {
        return UtilsFormatter::setDecimals($bytes / 1048576, 2);
    }


    /**
     * Convert bytes to gigabytes
     *
     * @param float $bytes The bytes quantity
     *
     * @return float The converted unit
     */
    public static function bytesToGibabytes($bytes)
    {
        return UtilsFormatter::setDecimals($bytes / 1073741824, 2);
    }


    /**
     * Convert bytes to terabytes
     *
     * @param float $bytes The bytes quantity
     *
     * @return float The converted unit
     */
    public static function bytesToTerabytes($bytes)
    {
        return UtilsFormatter::setDecimals($bytes / 1099511627776, 2);
    }


    /**
     * Convert kilobytes to bytes
     *
     * @param float $kilobytes The kilobytes quantity
     *
     * @return float The converted unit
     */
    public static function kilobytesToBytes($kilobytes)
    {
        return $kilobytes * 1024;
    }


    /**
     * Convert kilobytes to megabytes
     *
     * @param float $kilobytes The kilobytes quantity
     *
     * @return float The converted unit
     */
    public static function kilobytesToMegabytes($kilobytes)
    {
        return UtilsFormatter::setDecimals($kilobytes / 1024, 2);
    }


    /**
     * Convert kilobytes to gigabytes
     *
     * @param float $kilobytes The kilobytes quantity
     *
     * @return float The converted unit
     */
    public static function kilobytesToGigabytes($kilobytes)
    {
        return UtilsFormatter::setDecimals($kilobytes / 1048576, 2);
    }


    /**
     * Convert kilobytes to terabytes
     *
     * @param float $kilobytes The kilobytes quantity
     *
     * @return float The converted unit
     */
    public static function kilobytesToTerabytes($kilobytes)
    {
        return UtilsFormatter::setDecimals($kilobytes / 1073741824, 2);
    }


    /**
     * Convert megabytes to bytes
     *
     * @param float $megabytes The megabytes quantity
     *
     * @return float The converted unit
     */
    public static function megabytesToBytes($megabytes)
    {
        return $megabytes * 1048576;
    }


    /**
     * Convert megabytes to kilobytes
     *
     * @param float $megabytes The megabytes quantity
     *
     * @return float The converted unit
     */
    public static function megabytesToKiloytes($megabytes)
    {
        return $megabytes * 1024;
    }


    /**
     * Convert megabytes to gigabytes
     *
     * @param float $megabytes The megabytes quantity
     *
     * @return float The converted unit
     */
    public static function megabytesToGigabytes($megabytes)
    {
        return UtilsFormatter::setDecimals($megabytes / 1024, 2);
    }


    /**
     * Convert megabytes to terabytes
     *
     * @param float $megabytes The megabytes quantity
     *
     * @return float The converted unit
     */
    public static function megabytesToTerabytes($megabytes)
    {
        return UtilsFormatter::setDecimals($megabytes / 1048576, 2);
    }


}