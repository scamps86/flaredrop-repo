<?php

// Login
SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
$userData = SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID);

if ($userData) {
    $userData->name = UtilsHttp::getParameterValue('frmNick');
    $userData->firstName = UtilsHttp::getParameterValue('frmName');
    $userData->email = UtilsHttp::getParameterValue('frmEmail');
    $userData->password = base64_encode(UtilsHttp::getParameterValue('frmPassword'));
    $userData->location = UtilsHttp::getParameterValue('frmLocation');
    $userData->city = UtilsHttp::getParameterValue('frmCity');
    $userData->cp = UtilsHttp::getParameterValue('frmCp');
    $userData->country = UtilsHttp::getParameterValue('frmCountry');
    $userData->phone1 = UtilsHttp::getParameterValue('frmPhone1');
    $userData->phone2 = UtilsHttp::getParameterValue('frmPhone2');

    $result = SystemUsers::set($userData, false);

    if (!$result->state) {
        echo 'Error 1 ' . $result->description;
    } else {
        // Do the automatic relogin
        SystemUsers::logout(WebConfigurationBase::$DISK_WEB_ID);
        SystemUsers::login(UtilsHttp::getParameterValue('frmNick'), base64_encode(UtilsHttp::getParameterValue('frmPassword')), WebConfigurationBase::$DISK_WEB_ID);
    }
} else {
    echo 'Error 2';
}