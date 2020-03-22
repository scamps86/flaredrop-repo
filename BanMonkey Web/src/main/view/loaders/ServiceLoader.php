<?php

// Load the library
include_once '../../controller/system/SystemWebLoader.php';

// Load the loader base
include_once PATH_VIEW . 'loaders/ServiceLoaderBase.php';


// CUSTOM SERVICES
if (WebConstants::getServiceName() == 'RefreshAllBidding') {
    $service = new WebService('RefreshAllBidding');
    $service->validate('GET');
    $service->load();
}
if (WebConstants::getServiceName() == 'RefreshProductBidding') {
    $service = new WebService('RefreshProductBidding');
    $service->validate('GET');
    $service->load();
}
if (WebConstants::getServiceName() == 'DoBid') {
    $service = new WebService('DoBid');
    $service->validate('POST', ['productId']);
    $service->load();
}
if (WebConstants::getServiceName() == 'SignInFormSend') {
    $service = new WebService('SignInFormSend');
    $service->validate('POST', ['frmName', 'frmNick', 'frmEmail', 'frmPassword']);
    $service->load();
}
if (WebConstants::getServiceName() == 'UserDataFormSend') {
    $service = new WebService('UserDataFormSend');
    $service->validate('POST', ['frmName', 'frmNick', 'frmEmail', 'frmPassword', 'frmLocation', 'frmCity', 'frmCp', 'frmCountry', 'frmPhone1', 'frmPhone2']);
    $service->load();
}
if (WebConstants::getServiceName() == 'PayPalIPNValidateBansPack') {
    $service = new WebService('PayPalIPNValidateBansPack');
    $service->validate('POST');
    $service->load();
}
if (WebConstants::getServiceName() == 'PayPalIPNValidateBuyNow') {
    $service = new WebService('PayPalIPNValidateBuyNow');
    $service->validate('POST');
    $service->load();
}
if (WebConstants::getServiceName() == 'AccountCancel') {
    $service = new WebService('AccountCancel');
    $service->validate('POST');
    $service->load();
}
if (WebConstants::getServiceName() == 'RefreshUserSchedules') {
    $service = new WebService('RefreshUserSchedules');
    $service->validate('POST');
    $service->load();
}
if (WebConstants::getServiceName() == 'AuctionProductsList') {
    $service = new WebService('AuctionProductsList');
    $service->validate('GET');
    $service->load();
}
if (WebConstants::getServiceName() == 'AddSchedule') {
    $service = new WebService('AddSchedule');
    $service->validate('POST', ['frmProductId', 'frmMaxBans', 'frmMaxPrice']);
    $service->load();
}
if (WebConstants::getServiceName() == 'RemoveSchedule') {
    $service = new WebService('RemoveSchedule');
    $service->validate('POST', ['bidScheduleId']);
    $service->load();
}


// PRINT ERROR 404 NOT FOUND IF NOT EXISTS
UtilsHttp::error404();