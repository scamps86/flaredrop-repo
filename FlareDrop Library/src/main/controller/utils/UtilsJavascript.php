<?php

/** Javascript utils */
class UtilsJavascript
{
    private static $_vars = [];

    /**
     * Create a javascript var from a PHP value
     *
     * @param string $name The Javascript var name
     * @param mixed $value The Javascript var value
     * @param boolean $isBoolean If the value is a boolean or not. False by default
     */
    public static function newVar($name, $value, $isBoolean = false)
    {
        if ($isBoolean) {
            switch ($value) {
                case '1' :
                    $value = 1;
                    break;
                case 'true':
                    $value = 1;
                    break;
                default :
                    $value = 0;
            }
        } else {
            $value = json_encode($value);
        }
        array_push(self::$_vars, [$name, $value]);
    }


    /**
     * Echoes all previous defined vars and clear it
     */
    public static function echoVars()
    {
        if (count(self::$_vars) > 0) {
            echo '<script>var ';

            foreach (self::$_vars as $k => $v) {
                if ($k != 0) {
                    echo ',';
                }
                echo $v[0] . '=' . $v[1];
            }

            echo ';</script>';
        }
        self::$_vars = [];
    }
}