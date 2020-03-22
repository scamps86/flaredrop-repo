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


// PRINT ERROR 404 NOT FOUND IF NOT EXISTS
UtilsHttp::error404();