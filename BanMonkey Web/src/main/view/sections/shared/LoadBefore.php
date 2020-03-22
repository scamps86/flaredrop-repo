<?php

// Validate if the user is logged
$loginResult = SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
define('USER_LOGGED', $loginResult->state);


// Redirect to the home section when the user is not logged in an user section
if (substr(WebConstants::getSectionName(), 0, 4) == 'user' && !USER_LOGGED) {
    UtilsHttp::redirectToSection('home');
}