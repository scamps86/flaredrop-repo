<?php

class WebSection
{
    private static $_sectionJsName = '';
    private static $_cssFiles = [];
    private static $_jsFiles = [];
    private static $_metaTitle = '';
    private static $_metaDescription = '';
    private static $_loadPhpBefore = [];
    private static $_loadPhpInner = [];
    private static $_loadPhpAfter = [];
    private static $_htmlClass = '';
    private static $_bodyClass = '';
    private static $_externalJsScripts = [];


    /**
     * @param string $sectionName The mandatory section JS name
     */
    function __construct($sectionJsName)
    {
        // Define the section name
        self::$_sectionJsName = $sectionJsName;

        // Load predefined CSS and JS files
        self::$_cssFiles = WebConfigurationBase::$CSS;
        self::$_jsFiles = WebConfigurationBase::$JS;
    }


    /**
     * Removes all predefined CSS files
     */
    public static function removeCssFiles()
    {
        self::$_cssFiles = [];
    }


    /**
     * Removes all predefined JS files
     */
    public static function removeJsFiles()
    {
        self::$_jsFiles = [];
    }


    /**
     * Add more css files
     *
     * @param array $cssFiles
     */
    public static function addCssFiles(array $cssFiles)
    {
        self::$_cssFiles = array_merge(self::$_cssFiles, $cssFiles);
    }


    /**
     * Add more js files
     *
     * @param array $jsFiles
     */
    public static function addJsFiles(array $jsFiles)
    {
        self::$_jsFiles = array_merge(self::$_jsFiles, $jsFiles);
    }


    /**
     * Add a meta title. Max 50 characters
     *
     * @param $metaTitle
     */
    public static function addMetaTitle($metaTitle)
    {
        self::$_metaTitle = substr(htmlspecialchars(strip_tags($metaTitle)), 0, 50);
    }


    /**
     * Add a meta description. Max 255 characters
     *
     * @param $metaDescription
     */
    public static function addMetaDescription($metaDescription)
    {
        self::$_metaDescription = substr(htmlspecialchars(strip_tags($metaDescription)), 0, 255);
    }


    /**
     * Load a PHP script file before head. It also can access to the WebSection class as: self::
     *
     * @param string $phpFileUrl The php relative file path inside the sections folder
     * @param bool $loadBefore Load the file before meta tags or not. [False by default]
     */
    public static function loadPhpScriptBeforeHead($phpFilePath)
    {
        array_push(self::$_loadPhpBefore, PATH_VIEW . 'sections/' . $phpFilePath);
    }


    /**
     * Load a PHP script file inner head
     *
     * @param string $phpFileUrl The php relative file path inside the sections folder
     * @param bool $loadBefore Load the file before meta tags or not. [False by default]
     */
    public static function loadPhpScriptInnerHead($phpFilePath)
    {
        array_push(self::$_loadPhpInner, PATH_VIEW . 'sections/' . $phpFilePath);
    }


    /**
     * Load a PHP script file after head
     *
     * @param string $phpFileUrl The php relative file path inside the sections folder
     * @param bool $loadBefore Load the file before meta tags or not. [False by default]
     */
    public static function loadPhpScriptAfterHead($phpFilePath)
    {
        array_push(self::$_loadPhpAfter, PATH_VIEW . 'sections/' . $phpFilePath);
    }


    /**
     * Add a class on the main HTML tag
     *
     * @param string $htmlClass
     */
    public static function addHtmlClass($htmlClass)
    {
        self::$_htmlClass = $htmlClass;
    }


    /**
     * Add a class on the BODY tag
     *
     * @param string $bodyClass
     */
    public static function addBodyClass($bodyClass)
    {
        self::$_bodyClass = $bodyClass;
    }


    /**
     * Add external javascript libraries
     *
     * @param array $scriptUrls
     */
    public static function addExternalJsScripts(array $scriptUrls)
    {
        self::$_externalJsScripts = $scriptUrls;
    }


    /**
     * Echo the section only if the url allows it
     */
    public static function echoSection()
    {
        // Load PHP before
        foreach (self::$_loadPhpBefore as $path) {
            require $path;
        }

        // Get the cache code
        $cacheCode = self::_getCacheCode();

        // Open html tag
        echo '<!DOCTYPE html>';
        echo '<html lang="' . WebConstants::getLanguage() . '"' . (self::$_htmlClass == '' ? '>' : ' class="' . self::$_htmlClass . '">');

        // Set the global meta data
        echo '<head>';
        echo '<meta charset="utf-8">' . "\n";
        echo '<meta name="author" content="' . WebConfigurationBase::$WEBSITE_AUTHOR . '">' . "\n";
        echo '<meta name="viewport" content="width=' . WebConfigurationBase::$PAGE_WIDTH . ', height=' . WebConfigurationBase::$PAGE_HEIGHT . ', initial-scale=' . WebConfigurationBase::$PAGE_INITIAL_SCALE . ', user-scalable=' . (WebConfigurationBase::$PAGE_SCALABLE ? 'yes' : 'no') . '">' . "\n\n";

        // Set the section title and description
        echo '<title>' . self::$_metaTitle . '</title>' . "\n\n";
        echo '<meta name="description" content="' . self::$_metaDescription . '">' . "\n";

        // Load default favicon
        echo '<link href="' . UtilsHttp::getRelativeUrl('view/resources/images/shared/favicon.ico') . '" rel="shortcut icon" type="image/x-icon">' . "\n";

        // Load CSS files
        foreach (self::$_cssFiles as $c) {
            echo '<link href="' . UtilsHttp::getRelativeUrl($c) . $cacheCode . '" rel="stylesheet">' . "\n";
        }

        // Load jQuery libraries
        echo '<script src="' . UtilsHttp::getRelativeUrl('view/js/libraries/jquery/jquery.min.js') . $cacheCode . '"></script>' . "\n";
        echo '<script src="' . UtilsHttp::getRelativeUrl('view/js/libraries/jquery/jquery-ui.min.js') . $cacheCode . '"></script>' . "\n";
        echo '<script src="' . UtilsHttp::getRelativeUrl('view/js/libraries/touchPunch/jquery.ui.touch-punch.min.js') . $cacheCode . '"></script>' . "\n";

        // External scripts
        foreach (self::$_externalJsScripts as $s) {
            echo '<script src="' . $s . '"></script>' . "\n";
        }


        // Load FlareDrop JS for the web sections
        if (!self::_isManagerSection()) {
            echo '<script src="' . UtilsHttp::getRelativeUrl('view/js/' . WebConfigurationBase::$ANT_COMBINED_JS_FILE_NAME) . $cacheCode . '"></script>' . "\n";
        }

        // Load JS files
        foreach (self::$_jsFiles as $j) {
            echo '<script src="' . UtilsHttp::getRelativeUrl($j) . $cacheCode . '"></script>' . "\n";
        }

        // Generate the Google Analytics code only if the tracking code is defined
        if (WebConfigurationBase::$GOOGLE_ANALYTICS_TRACKING_CODE != '' && !WebConstants::isBrowserBot() && self::$_sectionJsName != '_manager') {
            echo '<script>';
            echo "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){";
            echo '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
            echo 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
            echo "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');";
            echo "ga('create', '" . WebConfigurationBase::$GOOGLE_ANALYTICS_TRACKING_CODE . "', 'auto');";
            echo "ga('send', 'pageview');";
            echo '</script>';
        }

        // Include FACEBOOK SDK for the buttons
        if (WebConfigurationBase::$FACEBOOK_INCLUDE_SDK) {
            echo '<div id="fb-root"></div>';
            echo '<script>(function(d, s, id) {';
            echo 'var js, fjs = d.getElementsByTagName(s)[0];';
            echo 'if (d.getElementById(id)) return;';
            echo 'js = d.createElement(s); js.id = id;';
            echo 'js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.3";';
            echo 'fjs.parentNode.insertBefore(js, fjs);';
            echo "}(document, 'script', 'facebook-jssdk'));</script>";
        }

        // Define the JS section name
        UtilsJavascript::newVar('SECTION_NAME', self::$_sectionJsName);
        UtilsJavascript::echoVars();

        // Generate the custom CSS configured from the manager, only if the manager is enabled and for web sections
        if (!self::_isManagerSection() && WebConfigurationBase::$ANT_MANAGER_GENERATION_ENABLED) {
            echo SystemManager::configurationCssGetAsCss(WebConfigurationBase::$ROOT_ID);
        }

        // Include the inner php script
        foreach (self::$_loadPhpInner as $path) {
            include $path;
        }

        // Close the head tag
        echo '</head>';

        // Open body tag
        echo '<body ' . (self::$_bodyClass == '' ? '>' : ' class="' . self::$_bodyClass . '">');

        // Show an alert if the browser version is less than IE9
        switch (WebConstants::getLanTag()) {
            case 'ca_ES' :
                $browserWarning = "El seu navegador és molt antic. Si us plau actualitzi'l.";
                break;
            case 'es_ES' :
                $browserWarning = 'Su navegador es muy antiguo. Por favor actualícelo.';
                break;
            default:
                $browserWarning = 'Your browser is too old. Please update it.';
                break;
        }

        echo '<!--[if lte IE 9]><div id="topBrowserWarning"><p>' . $browserWarning . "</p></div><![endif]-->\n";

        // Include the after PHP files
        foreach (self::$_loadPhpAfter as $path) {
            include $path;
        }

        // Close the section
        echo '</body></html>';
        die();
    }


    /**
     * Get the cache time code to concat it on the website JS and CSS links
     *
     * @return string A code like ?1387849745
     */
    private static function _getCacheCode()
    {
        return '?' . round(time() / (WebConfigurationBase::$CACHE_DURATION * 60));
    }


    /**
     * Get if the current section is a manager section or not
     *
     * @return bool
     */
    private static function _isManagerSection()
    {
        return self::$_sectionJsName == '_manager' || self::$_sectionJsName == '_managerApp';
    }
}
 