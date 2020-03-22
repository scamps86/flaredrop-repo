<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/ServiceLoaderBase.php';


// CUSTOM SERVICES
if (WebConstants::getServiceName() == 'UserJoin') {
    $service = new WebService('UserJoin');
    $service->validate('POST', ['frmEmail', 'frmPassword']);
    $service->load();
}
if (WebConstants::getServiceName() == 'JoinNewsletter') {
    $service = new WebService('JoinNewsletter');
    $service->validate('POST', ['frmEmail']);
    $service->load();
}
if (WebConstants::getServiceName() == 'ContactFormSend') {
    $service = new WebService('ContactFormSend');
    $service->validate('POST', ['frmName', 'frmEmail', 'frmMessage']);
    $service->load();
}
if (WebConstants::getServiceName() == 'PayPalIPNValidate') {
    $service = new WebService('PayPalIPNValidate');
    $service->validate('POST');
    $service->load();
}
if (WebConstants::getServiceName() == 'UserModify') {
    $service = new WebService('UserModify');
    $service->validate('POST');
    $service->load();
}
if (WebConstants::getServiceName() == 'UserUnregister') {
    $service = new WebService('UserUnregister');
    $service->validate('POST');
    $service->load();
}


// PRINT ERROR 404 NOT FOUND IF NOT EXISTS
UtilsHttp::error404();