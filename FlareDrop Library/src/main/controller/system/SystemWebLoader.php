<?php

define('PATH_ROOT', dirname(__FILE__) . '/../../');
define('PATH_CONTROLLER', PATH_ROOT . 'controller/');
define('PATH_MODEL', PATH_ROOT . 'model/');
define('PATH_VIEW', PATH_ROOT . 'view/');

// Import the required classes
function importClassesPath($path)
{
    spl_autoload_register(function ($c) use ($path) {
        if (file_exists($path . $c . '.php')) {
            require_once $path . $c . '.php';
        }
    });
}

importClassesPath(PATH_MODEL . 'vo/');
importClassesPath(PATH_MODEL . 'web/');
importClassesPath(PATH_CONTROLLER . 'utils/');
importClassesPath(PATH_CONTROLLER . 'managers/');
importClassesPath(PATH_CONTROLLER . 'system/');
importClassesPath(PATH_VIEW . 'components/');

// Initialize the errors manager
Managers::errors()->initialize();

// Override the custom configuration
require_once PATH_MODEL . '/web/WebConfiguration.php';

// Add the custom website constants
require_once PATH_MODEL . '/web/WebConstants.php';

// Store the current language to the locale's cookie
UtilsCookie::set('lan', WebConstants::getLanTag());

// If the locale is not defined on the url when it's a section, refresh it
if (isset($_SERVER['HTTP_HOST']) && !isset($_GET['l']) && WebConstants::getServiceName() == '') {
    UtilsHttp::redirectToSection(WebConstants::getSectionName() == '' ? WebConfigurationBase::$MAIN_SECTION : WebConstants::getSectionName());
}

