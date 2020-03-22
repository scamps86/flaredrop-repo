<?php

// Import required PHP files
require_once dirname(__FILE__) . '/controller/system/SystemWebLoader.php';


// Get the browser language
$lan = '';

if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $lan = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $lan = strtolower(substr(chop($lan[0]), 0, 2));
}

// Get the cookie locale if it's setted
$locale = UtilsCookie::get('locale');

// If the locale cookie is not defined, find if the detected language matches any of the ones in locales array, and set it
if ($locale == '') {
    foreach (WebConfigurationBase::$LOCALES as $v) {

        $tmp = explode('_', $v);

        if ($tmp[0] == $lan) {
            $locale = $v;
        }
    }
}

if ($locale == '') {
    $locale = WebConfigurationBase::$LOCALES[0];
}

// Get the language
$language = substr($locale, 0, 2);

// Redirect to the main section
UtilsHttp::redirectToSection(WebConfigurationBase::$MAIN_SECTION, null, $language);