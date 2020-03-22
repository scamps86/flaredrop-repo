<?php

/**
 * String utilities
 */
class UtilsString
{
    /**
     * Cut an string from start to the specified number of characters
     *
     * @param string $string The input string
     * @param int $limit Max number of characters
     *
     * @return string
     */
    public static function cut($string, $limit = 100)
    {
        if (strlen($string) <= $limit) {
            return $string;
        }
        return mb_strcut($string, 0, $limit, mb_detect_encoding($string));
    }


    /**
     * Encode an string as a json without the beginning and ending double quotes
     *
     * @param string $string The input string
     *
     * @return string
     */
    public static function jsonEncode($string)
    {
        return substr(json_encode($string, JSON_UNESCAPED_UNICODE), 1, -1);
    }


    /**
     * Encode an string to prevent errors in a regular expression
     *
     * @param string $string The input string
     *
     * @return string
     */
    public static function regexEncode($string)
    {
        return preg_quote($string, "\"");
    }


    /**
     * Add quotes on a SQL value
     *
     * @param string $string String that needs to be quoted
     *
     * @return string
     **/
    public static function sqlQuote($string)
    {
        if (!is_numeric($string)) {
            $string = addslashes($string);
        }
        return "'" . $string . "'";
    }


    /**
     * Remove all special characters from an string
     *
     * @param string $string The input string
     *
     * @return mixed
     */
    public static function specialCharsRemove($string)
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}