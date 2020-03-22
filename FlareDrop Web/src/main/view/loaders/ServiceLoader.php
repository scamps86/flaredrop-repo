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

if (WebConstants::getServiceName() == 'RequestFormSend') {
    $service = new WebService('RequestFormSend');
    $service->validate('POST', ['frmName', 'frmEmail', 'frmWebType', 'frmWebDesign', 'frmWebMaterial', 'frmWebLanguages', 'frmWebSections', 'frmWebSectionsDynamic', 'frmWebOthers']);
    $service->load();
}

if (WebConstants::getServiceName() == 'FlareDrop30101986Customers') {
    $service = new WebService('CronCustomers');
    $service->validate('GET');
    $service->load();
}


// PRINT ERROR 404 NOT FOUND IF NOT EXISTS
UtilsHttp::error404();