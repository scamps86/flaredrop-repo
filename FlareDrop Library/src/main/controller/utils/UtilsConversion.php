<?php

/**
 * Conversion utilities
 */
class UtilsConversion
{

    /**
     * Obfuscate a base64 encoded string. This string must be deofuscated before using it!
     *
     * @param string $string The base64 encoded string
     *
     * @return string
     */
    public static function base64Obfuscate($string)
    {
        return '.' . strtr($string, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 'yxafpmlnwgbsrtuhczqjiedkovCDSPQIHKUAZYWJNRMTEVBFGLOX6809173425');
    }


    /**
     * Deobfuscate an obfuscated base64 encoded string. This string must be previously obfuscated! if not, it will return the original base64 encoded string
     *
     * @param string $string The obfuscated base64 encoded string
     *
     * @return string
     */
    public static function base64Deobfuscate($string)
    {
        // Verify if tit's an encoded one
        if (strpos($string, '.') === false) {
            return $string;
        } else {
            return strtr(substr($string, 1), 'yxafpmlnwgbsrtuhczqjiedkovCDSPQIHKUAZYWJNRMTEVBFGLOX6809173425', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        }
    }
}