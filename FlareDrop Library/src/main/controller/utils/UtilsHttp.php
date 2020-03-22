<?php

/** HTTP utils */
class UtilsHttp
{

    /**
     * Get the current page full url, including 'http://', domain and all the get parameters
     *
     * @return string
     */
    public static function getFullURL()
    {
        return self::getAbsoluteUrl($_SERVER['REQUEST_URI']);
    }


    /**
     * Get the HTTP URL to any website section
     *
     * @param string $section The PHP section filename with or without .php extension
     * @param array $params An associative array containing the params to apply
     * @param string $dummy The url dummy text (OPTIONAL)
     * @param string $language Force the section url with an specified language (OPTIONAL)
     * @param boolean $getAbsoluteUrl Get the absolute or relative URL. Relative by default
     *
     * @return String The generated URL
     */
    public static function getSectionUrl($section, array $params = null, $dummy = '', $language = '', $getAbsoluteUrl = false)
    {
        // Get default language if not defined
        $language = $language == '' ? WebConstants::getLanguage() : $language;

        // Build the url
        $url = (!$getAbsoluteUrl ? self::getRelativeUrl($section) : self::getAbsoluteUrl($section)) . '/' . $language;

        if ($params != null && is_array($params)) {
            if (count($params) > 0) {
                $url .= '&' . rawurlencode(self::encodeParams($params));
            }
        }
        if ($dummy != '') {
            $dummy = strtolower($dummy);
            $dummy = strip_tags($dummy);
            $dummy = preg_replace('/[\/ &_]/', '-', $dummy);
            $dummy = rawurlencode($dummy);
            $url .= '&' . $dummy;
        }
        return htmlspecialchars($url);
    }


    /**
     * Get a service url
     *
     * @param string $name The service name
     * @param array $params Optional params to be sent to the service
     * @param boolean $getAbsoluteUrl Get the absolute or relative URL. Relative by default
     *
     * @return string The generated URL
     */
    public static function getWebServiceUrl($name, array $params = null, $getAbsoluteUrl = false)
    {
        $pUrl = '';
        if ($params != null && is_array($params)) {
            if (count($params) > 0) {
                $pUrl = '&' . self::encodeParams($params);
            }
        }
        return $getAbsoluteUrl ? self::getAbsoluteUrl('_webservice/' . $name . $pUrl) : self::getRelativeUrl('_webservice/' . $name . $pUrl);
    }


    /**
     * Get the HTTP URL to any file through its id
     *
     * @param int $fileId The file id
     * @param string $validationKey The validation key necessary for the private files
     * @param boolean $getAbsoluteUrl Get the absolute or relative URL. Relative by default
     *
     * @return string The generated URL
     */
    public static function getFileUrl($fileId, $validationKey = '', $getAbsoluteUrl = false)
    {
        $params = [];
        $params['fileId'] = $fileId;

        if ($validationKey != '') {
            $params['validationKey'] = $validationKey;
        }
        return self::getWebServiceUrl('FileGet', $params, $getAbsoluteUrl);
    }


    /**
     * @param int $fileId The file id
     * @param string $dimensions The picture dimensions like: 100x100
     * @param string $validationKey The validation key necessary for the private files
     * @return string
     */
    public static function getPictureUrl($fileId, $dimensions = '', $validationKey = '')
    {
        $params = [];
        $params['fileId'] = $fileId;

        if ($dimensions != '') {
            $params['dimensions'] = $dimensions;
        }
        if ($validationKey != '') {
            $params['validationKey'] = $validationKey;
        }
        return self::getWebServiceUrl('FileGet', $params);
    }


    /**
     * Get an absolute HTTP URL
     *
     * @param string $path The path from the root folder where the website is on the filesystem. EXAMPLE: http/myService.php
     * @return string
     */
    public static function getAbsoluteUrl($path = '')
    {
        // Remove the first slash
        if ($path != '') {
            if ($path[0] == '/') {
                $path = substr($path, 1);
            }
        }

        $url = 'http://' . WebConstants::getDomain() . self::getRootUrl();
        $url .= $path != '' ? htmlspecialchars($path) : '';

        return $url;
    }


    /**
     * Get the web root folder url
     *
     * @return String
     */
    public static function getRootUrl()
    {
        // Localhost or FTP
        if (strpos(dirname(__FILE__), '\\target_release\\') !== false) {
            return '/target_release/';
        }

        $path = explode('/public_html/', dirname(__FILE__));
        $path = explode('controller/', $path[1]);
        return '/' . $path[0];
    }


    /**
     * Get a relative HTTP URL
     *
     * @param string $path The path from the root folder where the website is on the filesystem. EXAMPLE: http/myService.php
     * @return string
     */
    public static function getRelativeUrl($path = '')
    {
        // Remove the first slash only if it exists
        if (strlen($path) > 0) {
            if ($path[0] == '/') {
                $path = substr($path, 1);
            }
        }

        $url = self::getRootUrl();
        $url .= $path != '' ? htmlspecialchars($path) : '';

        return $url;
    }


    /**
     * Redirect to a website section. This method must be called before any HTML code generation.
     *
     * @param string $section The section name
     * @param array $params An sarray containing the params
     * @param string $dummy The url dummy text (OPTIONAL)
     * @param string $language Force the section url with an specified language (OPTIONAL)
     */
    public static function redirectToSection($section, $params = null, $dummy = '', $language = '')
    {
        header('location: http://' . WebConstants::getDomain() . self::getSectionUrl($section, $params, $dummy, $language));
        die();
    }


    /**
     * Redirect a section to an external URL when it's being loaded. This method must be called before any HTML code generation
     *
     * @param string $section The PHP section filename without .php extension
     */
    public static function redirectToExternalUrl($url)
    {
        header('location; ' . $url);
        die;
    }


    /**
     * Get the POST or GET parameter. If it doesn't exist it will return an empty string
     *
     * @param string $key The parameter name
     * @param string $type POST or GET. [POST by default]
     *
     * @return string    The parameter value
     */
    public static function getParameterValue($key, $type = 'POST')
    {
        $val = '';

        if ($type != 'GET') {
            if (isset($_POST[$key])) {
                $val = $_POST[$key];
            }
        } else if (isset($_GET[$key])) {
            $val = $_GET[$key];
        }

        return $val;
    }


    /**
     * Get and decode the URL encoded parameters as an associative array. Empty array will be given if it doesn't exist
     * The encoded parameters can be base64 obfuscated or not.
     *
     * @return array    The parameters as an associative array. Not arrays of arrays because each parameter must have a different key
     */
    public static function getEncodedParamsArray()
    {
        $val = self::getParameterValue('p', 'GET');

        if ($val != '') {
            $val = base64_decode(UtilsConversion::base64Deobfuscate($val));
            if (is_string($val)) {
                $val = json_decode($val, true);
                return is_array($val) ? $val : [];
            }
        }
        return [];
    }


    /**
     * Get and decode the URL encoded parameter. An empty string will be given if it doesn't exist
     *
     * @return string    The parameter value
     */
    public static function getEncodedParam($key)
    {
        $params = self::getEncodedParamsArray();
        return isset($params[$key]) ? $params[$key] : '';
    }


    /**
     * Generate the URL parameters encoded string through an associative array containing each parameter.
     *
     * @param array $params The associative parameters array [key => value]
     *
     * @return string The encoded parameters string
     */
    public static function encodeParams(array $params)
    {
        return isset($params) ? UtilsConversion::base64Obfuscate(base64_encode(json_encode($params))) : '';
    }


    /**
     * Get the url default dummy. An empty string will be given if it doesn't exist
     *
     * @return string    The parameter value
     */
    public static function getDummy()
    {
        return isset($_GET['d']) ? $_GET['d'] : '';
    }


    /**
     * Generates a file headers for an HTTP request
     *
     * @param string $contentType The file content type (image/jpeg, application/pdf, ...)
     * @param int $fileSize The length of the file binary data (file size in bytes)
     * @param string $fileName [OPTIONAL] ]The name of the file with its extension
     * @param boolean $cachingEnabled [TRUE BY DEFAULT] Define if the file will be catched or not
     * @param string $modificationDate [OPTIONAL] Date when the file was modified (in a mysql format)
     *
     * @return void
     */
    public static function fileGenerateHeaders($contentType, $fileSize, $fileName, $cachingEnabled = true, $modificationDate = '')
    {
        if (!$cachingEnabled) {
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // disable IE caching
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Cache-Control: post-check=0, pre-check=0', false);
            header('Pragma: no-cache');
        } else {
            header('Pragma: private');
            header('Expires: ' . date(DATE_RFC822, strtotime('365 day')));

            if ($modificationDate != '') {
                if (!is_numeric($modificationDate)) {
                    $modificationDate = strtotime($modificationDate);
                }

                header('Last-Modified: ' . gmdate(DATE_RFC822, $modificationDate) . ' GMT'); // Note that we need the modification date to set the last modified value
            }
            header('Cache-Control: private, max-age=31536000, pre-check=31536000'); //max-age and pre-check values are set in seconds, and match the 365 days value
        }

        // Define the file headers
        header('Content-type: ' . $contentType);
        header('Content-disposition: inline; filename="' . $fileName . '";');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . $fileSize);
    }


    /**
     * Prints an error 301 header
     *
     * @param boolean $redirect Redirect to main section
     */
    public static function error301($redirect = true)
    {
        header('HTTP/1.1 301 Moved Permanently');

        if ($redirect) {
            self::redirectToSection(WebConfigurationBase::$MAIN_SECTION);
        } else {
            die();
        }
    }


    /**
     * Prints an error 404 header
     *
     * @param boolean $redirect Redirect to main section
     */
    public static function error404($redirect = true)
    {
        header('HTTP/1.1 404 Not Found');

        if ($redirect) {
            self::redirectToSection(WebConfigurationBase::$MAIN_SECTION);
        } else {
            die();
        }
    }
}