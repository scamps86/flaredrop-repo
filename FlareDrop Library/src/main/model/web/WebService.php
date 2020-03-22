<?php

class WebService
{
    private static $_name = '';
    private static $_files = null;


    /**
     * @param string $sectionName The mandatory section JS name
     */
    function __construct($name)
    {
        // Define the service name
        self::$_name = $name;
    }


    /**
     * Load the webservice
     */
    public function load()
    {
        require PATH_VIEW . 'webservices/' . self::$_name . '.php';
        die();
    }


    /**
     * Validate the current service requirements (method, params and no-bots). If not, it will be stopped
     *
     * @param string $method POST or GET (POST by default)
     * @param array $requiredParams Required service parameters. If null, no params needed
     *
     */
    public static function validate($method = 'POST', array $requiredParams = null)
    {
        if ($method != $_SERVER['REQUEST_METHOD']) {
            UtilsHttp::error404();
            die();
        }

        if ($requiredParams != null) {
            $params = $method == 'POST' ? $_POST : UtilsHttp::getEncodedParamsArray();
            foreach ($requiredParams as $p) {
                if (!array_key_exists($p, $params)) {
                    UtilsHttp::error404();
                    die();
                }
            }
        }
        if (WebConstants::isBrowserBot()) {
            UtilsHttp::error404();
            die();
        }
    }


    /**
     * Validate the service uploaded files and get an array containing the files data. This adds a "inputName" property
     * that indicates the file input name, and a "extension" property to indicate the file extension (in lower case) through its name
     *
     * @param string $restrictTypes The restrict file types separated by ;. Example: image/jpeg;image/png
     */
    public static function filesValidate($restrictTypes = '')
    {
        self::$_files = [];

        foreach ($_FILES as $k => $f) {
            // Not allow commas and ; on the file name, to prevent future problems when getting a the concatenated ones
            $f['name'] = str_replace(',', '.', $f['name']);
            $f['name'] = str_replace(';', '.', $f['name']);

            if ($f['error'] > 0) {
                UtilsHttp::error404();
                die();
            }

            if ($f['size'] <= 0) {
                UtilsHttp::error404();
                die();
            }

            if ($restrictTypes != '') {
                if (!in_array($f['type'], explode(';', $restrictTypes))) {
                    UtilsHttp::error404();
                    die();
                }
            }
            $f['inputName'] = $k;
            $f['extension'] = Managers::ftpFileSystem()->fileExtension($f['name']);
            $f['data'] = '';
            array_push(self::$_files, $f);
        }
    }
}
 