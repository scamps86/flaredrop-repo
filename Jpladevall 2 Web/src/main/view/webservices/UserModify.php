<?php

// Login
SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
$userData = SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID);

if ($userData) {
    $userData->name = UtilsHttp::getParameterValue('frmEmail');
    $userData->email = UtilsHttp::getParameterValue('frmEmail');
    $userData->password = base64_encode(UtilsHttp::getParameterValue('frmPassword'));
    $userData->location = UtilsHttp::getParameterValue('frmLocation');
    $userData->country = UtilsHttp::getParameterValue('frmCountry');
    $userData->region = UtilsHttp::getParameterValue('frmRegion');
    $userData->city = UtilsHttp::getParameterValue('frmCity');
    $userData->cp = UtilsHttp::getParameterValue('frmCp');
    $userData->firstName = UtilsHttp::getParameterValue('frmName');
    $userData->phone1 = UtilsHttp::getParameterValue('frmPhone');

    $userData->data = json_encode([
        'fiscalName' => UtilsHttp::getParameterValue('frmFiscalName'),
        'shopName' => UtilsHttp::getParameterValue('frmShopName'),
        'NIFCIF' => UtilsHttp::getParameterValue('frmNIFCIF'),
        'mobile' => UtilsHttp::getParameterValue('frmMobile'),
        're' => UtilsHttp::getParameterValue('frmRe')
    ]);

    $result = SystemUsers::set($userData, false);

    if (!$result->state) {
        echo 'Error 1 ' . $result->description;
    } else {
        // Do the automatic relogin
        SystemUsers::logout(WebConfigurationBase::$DISK_WEB_ID);
        SystemUsers::login(UtilsHttp::getParameterValue('frmEmail'), base64_encode(UtilsHttp::getParameterValue('frmPassword')), WebConfigurationBase::$DISK_WEB_ID);
    }
}