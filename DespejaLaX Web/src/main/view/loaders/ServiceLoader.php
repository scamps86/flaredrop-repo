<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/ServiceLoaderBase.php';


// CUSTOM SERVICES
if (WebConstants::getServiceName() == 'contact') {
    $service = new WebService('Contact');
    $service->validate('POST', ['frmName', 'frmEmail', 'frmMessage']);
    $service->load();
}
if (WebConstants::getServiceName() == 'userLogin') {
    $service = new WebService('UserLogin');
    $service->validate('POST', []);
    $service->load();
}
if (WebConstants::getServiceName() == 'userJoin') {
    $service = new WebService('UserJoin');
    $service->validate('POST', ['frmName', 'frmNick', 'frmEmail', 'frmPassword']);
    $service->load();
}
if (WebConstants::getServiceName() == 'gameGetListInfo') {
    $service = new WebService('GameGetListInfo');
    $service->validate('GET');
    $service->load();
}
if (WebConstants::getServiceName() == 'gameStart') {
    $service = new WebService('GameStart');
    $service->validate('POST', ['gameId']);
    $service->load();
}
if (WebConstants::getServiceName() == 'issueGenerate') {
    $service = new WebService('IssueGenerate');
    $service->validate('GET');
    $service->load();
}
if (WebConstants::getServiceName() == 'issueEvaluate') {
    $service = new WebService('IssueEvaluate');
    $service->validate('POST', ['solution']);
    $service->load();
}
if (WebConstants::getServiceName() == 'PayPalIPNValidateTickets') {
    $service = new WebService('PayPalIPNValidateTickets');
    $service->validate('POST');
    $service->load();
}

// PRINT ERROR 404 NOT FOUND IF NOT EXISTS
UtilsHttp::error404();