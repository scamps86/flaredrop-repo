<?php

/**
 * Cookie utilities
 */
class UtilsCookie
{

    /**
     * Get an stored cookie. If the cookie is not defined, it will return an empty string
     *
     * @param string $key The cookie key name
     *
     * @return string
     */
    public static function get($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : '';
    }

    /**
     * Store a cookie on the current browser
     *
     * @param string $key The cookie key name
     * @param string $value The cookie value
     * @param string $expires The expiration time in seconds. A year if not defined
     *
     * @return boolean    If the cookie successfully runs
     */
    public static function set($key, $value, $expires = 31536000)
    {
        return setcookie($key, $value, time() + $expires, '/');
    }


    /**
     * Deletes the specified cookie from browser. Note that the cookie will only be deleted if belongs to the same path as specified.
     *
     * @param string $key The name of the cookie we want to delete
     * @param string $path Define the path where the cookie is set. By default it is the whole domain: '/'. If the cookie is not set on this path, we must pass the cookie domain or the delete will fail.
     *
     * @return boolean Cookie value or null
     */
    public static function delete($key, $path = '/')
    {
        if (isset($_COOKIE[$key])) {
            setcookie($key, '', null, $path);
            return true;
        }

        return false;
    }
}