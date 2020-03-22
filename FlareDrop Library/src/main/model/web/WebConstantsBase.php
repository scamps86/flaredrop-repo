<?php


class WebConstantsBase
{

    // The manager global variables as an associative array
    private static $_managerGlobalVariables = null;


    /**
     * Get the current website locale as xx_XX format. It depends only of the language defined on the URL or using a forced GET parameter named 'l'
     *
     * @return String
     */
    public static function getLanTag()
    {
        foreach (WebConfigurationBase::$LOCALES as $v) {
            $tmp = explode('_', $v);

            // Find if the url language matches any of the ones in locales array
            if (isset($_GET['l'])) {
                if ($tmp[0] == $_GET['l']) {
                    return $v;
                }
            }
        }

        // If the browser locale is not found on our list, we will load the page for the first element of the locales array, so it is considered the default one
        return WebConfigurationBase::$LOCALES[0];
    }


    /**
     * Get the current website language as xx
     *
     * @return String
     */
    public static function getLanguage()
    {
        return substr(self::getLanTag(), 0, 2);
    }


    /**
     * Get the section name
     *
     * @return string
     */
    public static function getSectionName()
    {
        return UtilsHttp::getParameterValue('s', 'GET');
    }


    /**
     * Get the web service name
     *
     * @return string
     */
    public static function getServiceName()
    {
        return UtilsHttp::getParameterValue('w', 'GET');
    }


    /**
     * Get the current page domain, without the http:// string. For example, if we are on http://test1.domain.com/home/1232, we will get: test1.domain.com.
     *
     * @return string
     */
    public static function getDomain()
    {
        return $_SERVER['HTTP_HOST'];
    }


    /**
     * Get if the browser is a bot or not
     *
     * @return boolean
     */
    public static function isBrowserBot()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/slurp|grub|[Bb]ot|archiver|NetMonitor/', $_SERVER['HTTP_USER_AGENT']);
    }


    /**
     * Tells if the website is in production
     *
     * @return boolean
     */
    public static function isInProduction()
    {
        return strpos(UtilsHttp::getFullURL(), '/_preview/') === false;
    }


    /**
     * Get a manager configured global variable value. If not defined it will return NULL.
     * At the first call we get all variables and it are stored.
     *
     * @param string $name The variable name
     * @param string $type The variable type: BOOLEAN, INTEGER, FLOAT or STRING. String by default. If the variable doesn't mach the type, it will return false as boolean
     *
     * @return mixed The variable value
     */
    public static function getVariable($name, $type = 'STRING')
    {
        if (self::$_managerGlobalVariables == null && WebConfigurationBase::$ANT_MANAGER_GENERATION_ENABLED) {
            self::$_managerGlobalVariables = SystemManager::configurationVarGet(WebConfigurationBase::$ROOT_ID);
        }
        $var = isset(self::$_managerGlobalVariables[$name]) ? self::$_managerGlobalVariables[$name] : null;

        if ($var == null) {
            return $var;
        }

        switch ($type) {
            case 'BOOLEAN':
                $type = FILTER_VALIDATE_BOOLEAN;
                break;
            case 'INTEGER':
                $type = FILTER_VALIDATE_INT;
                break;
            case 'FLOAT':
                $type = FILTER_VALIDATE_FLOAT;
                break;
            default:
                $type = FILTER_DEFAULT;
        }

        return filter_var($var, $type);
    }
}
 