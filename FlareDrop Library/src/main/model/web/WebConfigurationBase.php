<?php

class WebConfigurationBase
{
    /** Website title */
    public static $WEBSITE_TITLE = 'Website title';

    /** Website author */
    public static $WEBSITE_AUTHOR = 'FlareDrop Development';

    /** The website locales array by priority */
    public static $LOCALES = ['ca_ES', 'es_ES', 'en_US'];

    /** Global Javascript files that will be loaded for each website sections */
    public static $JS = [];

    /** Global CSS files that will be loaded for each website sections */
    public static $CSS = [];

    /** Starting website section name */
    public static $MAIN_SECTION = 'home';

    /** Browser cache duration in minutes for CSS and JS files */
    public static $CACHE_DURATION = 68400;

    /** Enable web under construction section.*/
    public static $WEB_UNDER_CONSTRUCTION_ENABLED = true;

    /** Allow access to the system webservices */
    public static $SYSTEM_WEBSERVICES_ENABLED = false;

    /** Enter a number (pixels assumed), or the keyword "device-width" to set the viewport to the physical width of the device's screen */
    public static $PAGE_WIDTH = 'device-width';

    /** Enter a number (pixels assumed), or the keyword "device-height" to set the viewport to the physical height of the device's screen */
    public static $PAGE_HEIGHT = 'device-height';

    /** The initial zoom of the webpage, where a value of 1 means no zoom */
    public static $PAGE_INITIAL_SCALE = 1;

    /** Sets whether the user can zoom in and out of a webpage */
    public static $PAGE_SCALABLE = true;

    /** Send all error notifications to the email. The notifications wont be sent if this value is empty */
    public static $ERROR_NOTIFY_MAIL = 'flaredropdevelopment@gmail.com';

    /** The error source email */
    public static $ERROR_NOREPLY_MAIL = 'noreply@flaredrop.com';

    /** Defines the root id to use on the website */
    public static $ROOT_ID = 1;

    /** @var int Define the privilege ids */
    public static $PRIVILEGE_READ_ID = 1;
    public static $PRIVILEGE_WRITE_ID = 2;

    /** Defines the main disks */
    public static $DISK_MANAGER_ID = 1;
    public static $DISK_WEB_ID = 2;

    /** Enable manager configuration */
    public static $MANAGER_CONFIGURABLE = false;

    /** Mail definitions */
    public static $MAIL_COMMERCIAL = 'comercial@flaredrop.com';
    public static $MAIL_TECNIC = 'tecnic@flaredrop.com';
    public static $MAIL_NOREPLY = 'noreply@flaredrop.com';

    /** PayPal constants */
    public static $PAYPAL_SANDBOX = true;
    public static $PAYPAL_BUSINESS = ''; // Customer business PayPal
    public static $PAYPAL_FD_BUSINESS = 'comercial@flaredrop.com'; // FlareDrop business PayPal for intranet usages

    /** TPV constants */
    public static $TPV_URL_TPVV_TEST = 'https://sis-t.redsys.es:25443/sis/realizarPago';
    public static $TPV_URL_TPVV = 'https://sis.redsys.es/sis/realizarPago';
    public static $TPV_KEY = 'qwertyasdf0123456789';
    public static $TPV_CODE = 'xxxxxxxxx'; // Merchant code
    public static $TPV_TERMINAL = '001'; // Merchant terminal
    public static $TPV_CURRENCY = '978'; // 978 = €
    public static $TPV_TRANSACTION_TYPE = 0;

    /** Google Analytics tracking code */
    public static $GOOGLE_ANALYTICS_TRACKING_CODE = '';

    /** Database configuration */
    public static $MYSQL_HOST = 'localhost';
    public static $MYSQL_DATABASE = 'flaredro_preview';
    public static $MYSQL_USER = 'flaredro';
    public static $MYSQL_PASSWORD = 'lG=9}$dpF0v5';

    /** FACEBOOK */
    public static $FACEBOOK_INCLUDE_SDK = false; // To add Facebook buttons

    /** ANT CONFIGURATION */
    public static $ANT_MINIFY_ENABLED = false; // If the website is minified or not (it will be replaced by ant processes)
    public static $ANT_COMBINED_JS_FILE_NAME = ''; // The website side concatenated file name
    public static $ANT_MANAGER_GENERATION_ENABLED = false; // If the manager is generated
}