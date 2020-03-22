<?php

/** Array utils */
class UtilsArray
{

    /**
     * Extract a property value for each associative array item
     *
     * @param array $array The input array of associative arrays
     * @param string $property The property name to extract
     *
     * @return array A simple array with each property values
     */
    public static function extractProperty(array $array, $property)
    {
        $result = [];
        foreach ($array as $v) {
            if (isset($v[$property])) {
                array_push($result, $v[$property]);
            }
        }
        return $result;
    }


    /**
     * Remove all similar values defined to the given array
     *
     * @param array $array The input array
     * @param array $values An array containing the values to be removed from the input array
     *
     * @return array
     */
    public static function removeValues(array $array, array $values)
    {
        foreach ($values as $v) {
            if (($key = array_search($v, $array)) !== false) {
                unset($array[$key]);
            }
        }
        return $array;
    }


    /**
     * Replace the characters on the key / value of an associative array
     *
     * @param array $array The input array
     * @param string $search The characters to be modified
     * @param string $replace The characters to apply
     *
     * @return array
     */
    public static function replaceChars(array $array, $search, $replace)
    {
        $result = [];
        foreach ($array as $k => $v) {
            $result[str_replace($search, $replace, $k)] = str_replace($search, $replace, $v);
        }
        return $result;
    }


    /**
     * Move an associative array item to the first position by its key. If the item is not defined in the array, it will return the input one
     *
     * @param array $array The input array
     * @param string $key The array key
     *
     * @return array
     */
    public static function moveItemToFirstPosition(array $array, $key)
    {
        $value = $array[$key];
        unset($array[$key]);
        $array = array_reverse($array, true);
        $array[$key] = $value;
        return array_reverse($array, true);
    }


    /**
     * Verify if an array is associative or not
     *
     * @param array $array The input array
     *
     * @return boolean
     */
    public static function isAssociative(array $array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }


    /**
     * Convert an array to a class
     *
     * @param array $array The input array
     * @param Object $class The class type object
     *
     * @return mixed
     */
    public static function arrayToClass(array $array, $class)
    {
        $object = new $class;
        foreach ($array as $k => $v) {
            if (property_exists($class, $k)) {
                $object->{$k} = $v;
            }
        }
        return $object;
    }


    /**
     * Convert a class to an associative array
     *
     * @param Object $class The class that will be converted
     *
     * @return array The resulting associative array
     */
    public static function classToArray($class)
    {
        $array = [];

        foreach ($class as $p => $v) {
            $array[$p] = $v;
        }
        return $array;
    }


    /**
     * Generate an array containing objects as the defined class name
     *
     * @param array $array The input array containing in each row the objects as an associative array
     * @param string $className The class name
     *
     * @return array The array containing all objects
     */
    public static function arrayToClassArray(array $array, $className)
    {
        $result = [];
        foreach ($array as $a) {
            array_push($result, self::arrayToClass($a, new $className));
        }
        return $result;
    }


    /**
     * Generate an SQL condition from an array
     *
     * @param array $values The array containing the values to be considered
     * @param string $before The string that will be applied before each value
     * @param string $logical The operator that will join all the array values. OR by default
     *
     * @return string The condition string
     */
    public static function sqlArrayToCondition(array $values, $before = '', $logical = 'OR')
    {
        $result = '';
        foreach ($values as $k => $v) {
            $result .= ' ' . ($k > 0 ? $logical : '') . ' ' . $before . $v;
        }
        return $result == '' ? $result : '(' . ltrim($result) . ')';
    }


    /**
     * Sort an array of associative arrays. That associative arrays must have the same keys
     *
     * @param array $array The input array
     * @param string $key The associative array key
     * @param int $type The sorting type. ASC by default
     *
     * @return array
     */
    public static function arrayOfAssociativeArraysSort($array, $key, $type = SORT_ASC)
    {
        $sArray = [];
        foreach ($array as $k => $row) {
            if (isset($row[$key])) {
                $sArray[$k] = $row[$key];
            } else {
                return $array;
            }
        }
        array_multisort($sArray, $type, $array);
        return $array;
    }


    /**
     * Generate a CSV string through an array of associative arrays
     *
     * @param array $columns The array containing the columns to put in each line
     * @param array $data The array of associative arrays containing the columns
     * @param string $delimiter The CSV delimiter. ";" by default
     * @param string $enclosure The CSV enclosure. " by default
     *
     * @return string The CSV as an string
     */
    public static function arrayToCsv(array $columns, array $data, $delimiter = ';', $enclosure = '"')
    {
        $csv = '';
        $handle = fopen('php://temp', 'r+');

        // Put the columns
        fputcsv($handle, $columns, $delimiter, $enclosure);

        // Iterate each data line
        foreach ($data as $d) {
            $line = [];

            foreach ($columns as $c) {
                array_push($line, isset($d[$c]) ? $d[$c] : '');
            }

            // Put the data line
            fputcsv($handle, array_map('utf8_decode', array_values($line)), $delimiter, $enclosure);
        }

        rewind($handle);
        while (!feof($handle)) {
            $csv .= fread($handle, 8192);
        }
        fclose($handle);
        return $csv;
    }


    /**
     * Convert a CSV to an associative array. If this cannot be converted, a null object will be returned.
     *
     * @param string $csv The csv data as an string
     *
     * @return array of associative arrays containing the csv data
     */
    public static function csvToArray($csv, $delimiter = ';', $enclosure = '"')
    {
        // Define the result
        $result = [];

        // Encode as UTF8
        $csv = utf8_encode($csv);

        // Separate the CSV by rows
        $rows = explode(PHP_EOL, $csv);

        // Columns
        $columns = [];

        foreach ($rows as $i => $r) {
            if ($i == 0) {
                $columns = str_getcsv($r, $delimiter, $enclosure);
            } else {
                $line = str_getcsv($r, $delimiter, $enclosure);
                $row = [];

                foreach ($line as $k => $p) {
                    $row[$columns[$k]] = $p;
                }
                array_push($result, $row);
            }
        }

        // Validate the column names (a-z, A-Z, 0-9, ;)
        if (isset($columns)) {
            if (preg_match("/^[a-zA-Z0-9;]+$/", $rows[0]) == 1) {
                return $result;
            }
        }
        return null;
    }
}