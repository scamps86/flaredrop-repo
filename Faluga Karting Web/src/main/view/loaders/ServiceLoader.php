<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/ServiceLoaderBase.php';


// CUSTOM SERVICES
if (WebConstants::getServiceName() == 'ContactFormSend') {
    $service = new WebService('ContactFormSend');
    $service->validate('POST', ['frmName', 'frmEmail', 'frmMessage']);
    $service->load();
}

if (WebConstants::getServiceName() == 'CheckoutFormSend') {
    $service = new WebService('CheckoutFormSend');
    $service->validate('POST', ['frmName', 'frmPhone', 'frmEmail', 'frmLocation', 'frmCity', 'frmCp', 'frmCart', 'frmTotalPrice']);
    $service->load();
}

if (WebConstants::getServiceName() == 'ValidateIpn') {
    $service = new WebService('ValidateIpn');
    $service->validate('POST');
    $service->load();
}

if (WebConstants::getServiceName() == 'ValidateTpv') {
    $service = new WebService('ValidateTpv');
    $service->validate('POST');
    $service->load();
}


// PRINT ERROR 404 NOT FOUND IF NOT EXISTS
UtilsHttp::error404();