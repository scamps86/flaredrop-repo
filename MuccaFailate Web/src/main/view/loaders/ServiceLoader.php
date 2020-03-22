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

if (WebConstants::getServiceName() == 'GenerateTicket') {
    $service = new WebService('GenerateTicket');
    $service->validate('POST', ['frmFullName', 'frmEmail', 'frmDni']);
    $service->load();
}

if (WebConstants::getServiceName() == 'ValidateTicket') {
    $service = new WebService('ValidateTicket');
    $service->validate('POST', ['code']);
    $service->load();
}


// PRINT ERROR 404 NOT FOUND IF NOT EXISTS
UtilsHttp::error404();