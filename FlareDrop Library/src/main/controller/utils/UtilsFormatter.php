<?php

/**
 * String utilities
 */
class UtilsFormatter
{

    /**
     * Set the decimal quantity on a number
     *
     * @param int $value The value to be formatted
     * @param int $decimals The number of decimals to apply
     *
     * @return float The formatted value
     */
    public static function setDecimals($value, $decimals)
    {
        return number_format(floatval($value), $decimals, ',', '');
    }


    /**
     * Format as currency
     *
     * @param int $value The value to be formatted
     * @param string $currency The currency. € by default
     *
     * @return string
     */
    public static function currency($value, $currency = '€')
    {
        return number_format(floatval($value), 2, ',', '.') . $currency;
    }


    /**
     * Pad an string
     *
     * @param string $value The string value
     * @param int $length The length to pad
     * @param string $string The pad string. ' ' by default
     * @param string $type The pad type: LEFT, RIGHT (left by default)
     *
     * @return string
     */
    public static function pad($value, $length, $string = ' ', $type = 'LEFT')
    {
        $type = $type == 'RIGHT' ? STR_PAD_RIGHT : STR_PAD_LEFT;
        return str_pad($value, $length, $string, $type);
    }

}