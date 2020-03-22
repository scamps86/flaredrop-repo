<?php


/**
 * Class ManagerLiteralss
 */
class ManagerLiterals
{

    // Store all bundle data
    private $_bundles = null;


    /**
     * Constructor method that reads and customizes all property files data and stores it o a bundle data object
     */
    function ManagerLiterals()
    {
        $path = PATH_MODEL . 'literals/';
        $this->_bundles = [];

        $folders = Managers::ftpFileSystem()->dirList($path);

        // Get folder names
        foreach ($folders as $f) {
            $files = Managers::ftpFileSystem()->dirList($path . $f . '/');

            // Get file names inside the each locale folers
            foreach ($files as $l) {
                // Get the name and extension of the .ini file
                $file = explode('.ini', $l);

                // Get the ini file url
                $fileUrl = $this->_getBundleFilePath($file[0], $f);

                // Add each bundle data to the result array
                if (is_file($fileUrl) && substr($fileUrl, -4) == '.ini') {
                    $this->_bundles[$f][$file[0]] = parse_ini_file($fileUrl);
                }
            }
        }

        // Save the default locale to allow getting it from javascript when it's sent by AJAX
        $this->_bundles['default'] = WebConstants::getLanTag();
    }


    /**
     * Get a locale value defined on the ini file. If the key doesn't exist, it will return the key like this: {KEY}
     *
     * @param string $key The locale key
     * @param string $bundle The locales resource bundle name
     * @param string $locale The current locale. If not defined, it will use the default one
     * @param boolean $htmlCarachersEncode Encode the html characters to be displayed as a text. False by default
     *
     * @return string
     */
    public function get($key, $bundle, $locale = '', $htmlCarachersEncode = false)
    {
        $bundle = $this->getBundle($bundle, $locale);

        if ($bundle != null) {
            foreach ($bundle as $k => $v) {
                if ($k == $key) {
                    return $htmlCarachersEncode ? htmlspecialchars($v) : $v;
                }
            }
        }

        return '{' . $key . '}';
    }


    /**
     * Get the locales resource bundle as an array. If it doesn't exist, it will return a null object
     *
     * @param string $bundle The locales resource bundle name
     * @param string $locale The current locale. If not defined, it will use the default one
     *
     * @return array    A full locale list of this resource bundle as an associative array
     */
    public function getBundle($bundle, $locale = '')
    {
        // Get the default locale if it's not defined
        $locale = $locale == '' ? WebConstants::getLanTag() : $locale;

        if (isset($this->_bundles[$locale])) {
            if (isset($this->_bundles[$locale][$bundle])) {
                return $this->_bundles[$locale][$bundle];
            }
        }

        return null;
    }


    /**
     * Get all locale bundle files (included the manager ones) inside an associative array using this structure:    [xx_XX] => [bundle] => [data]. It also has a property named "default" that
     * has the default locale to allow javascript identify it
     *
     * @return array
     */
    public function getBundles()
    {
        return $this->_bundles;
    }


    /**
     * Get all manager locale bundle files inside an associative array using this structure:    [xx_XX] => [bundle] => [data]. It also has a property named "default" that
     * has the default locale to allow javascript identify it
     *
     * @return array
     */
    public function getManagerBundles()
    {
        $result = $this->_bundles;

        foreach ($result as $localeKey => $localeBundle) {
            if (is_array($localeBundle)) {
                foreach ($localeBundle as $bundleKey => $bundleValue) {
                    if (substr($bundleKey, 0, 7) != 'Manager') {
                        unset($result[$localeKey][$bundleKey]);
                    }
                }
            }
        }
        return $result;
    }


    /**
     * Get a locale resource bundle filesystem path
     *
     * @param string $bundle The locales resource bundle name
     * @param string $locale The current locale. If not defined, it will use the default one
     *
     * @return string
     */
    private function _getBundleFilePath($bundle, $locale = '')
    {
        // Get the current locale if not defined
        if ($locale == '') {
            $locale = WebConstants::getLanTag();
        }

        // Return the ini file url
        return PATH_MODEL . 'literals/' . $locale . '/' . $bundle . '.ini';
    }
}