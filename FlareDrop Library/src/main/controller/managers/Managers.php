<?php

/*
 * Managers
 */

class Managers
{

    private static $_errors = null;
    private static $_ftpFileSystem = null;
    private static $_mySQL = null;
    private static $_mailing = null;
    private static $_literals = null;
    private static $_payPal = null;
    private static $_timer = null;


    /**
     * Initialize and get the errors manager
     *
     * @return ManagerErrors
     */
    public static function errors()
    {
        if (!isset(self::$_errors)) {
            self::$_errors = new ManagerErrors();
        }
        return self::$_errors;
    }


    /**
     * Initialize and get the ftp filesystem manager
     *
     * @return ManagerFtpFileSystem
     */
    public static function ftpFileSystem()
    {
        if (!isset(self::$_ftpFileSystem)) {
            self::$_ftpFileSystem = new ManagerFtpFileSystem();
        }
        return self::$_ftpFileSystem;
    }


    /**
     * Initialize and get the MySQL manager. This is a singleton connection!
     *
     * @param boolean $securityEnabled Requires an user session. Enabled by default.
     * @param int $securityUserDiskId The user disk id only if the security is enabled. 1 by default
     *
     * @return ManagerMySql
     */
    public static function mySQL($securityEnabled = true, $securityUserDiskId = 1)
    {
        if (!isset(self::$_mySQL)) {
            // Do the security validation
            if ($securityEnabled) {
                if (!SystemUsers::login('', '', $securityUserDiskId)->state) {
                    echo 'MySQL connection error 1';
                    die();
                }
                // Destroy session to prevent session blocking requests
                session_write_close();
            }
            self::$_mySQL = new ManagerMySql();
        }
        return self::$_mySQL;
    }


    /**
     * Initialize and get the mailing manager
     *
     * @return ManagerMailing
     */
    public static function mailing()
    {
        if (!isset(self::$_mailing)) {
            self::$_mailing = new ManagerMailing();
        }
        return self::$_mailing;

    }


    /**
     * Initialize and get the literals manager
     *
     * @return ManagerLiterals
     */
    public static function literals()
    {
        if (!isset(self::$_literals)) {
            self::$_literals = new ManagerLiterals();
        }
        return self::$_literals;
    }


    /**
     * Initialize and get the paypal manager
     *
     * @return ManagerPayPal
     */
    public static function payPal()
    {
        if (!isset(self::$_payPal)) {
            self::$_payPal = new ManagerPayPal();
        }
        return self::$_payPal;
    }


    /**
     * Initialize and get the timer manager
     *
     * @return ManagerTimer
     */
    public static function timer()
    {
        if (!isset(self::$_timer)) {
            self::$_timer = new ManagerTimer();
        }
        return self::$_timer;
    }
}