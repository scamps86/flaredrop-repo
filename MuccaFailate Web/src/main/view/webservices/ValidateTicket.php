<?php

SystemUsers::login('', '', WebConfigurationBase::$DISK_WEB_ID);
$user = SystemUsers::getLogged(WebConfigurationBase::$DISK_WEB_ID);

if ($user == null) {
    echo 'ERROR NO USER SESSION';
    die();
}

// Get the code from POST data
$code = UtilsHttp::getParameterValue('code');

// Get the ticket by code
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_MANAGER_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setPropertyMatch('code', $code);

$tickets = SystemDisk::objectsGet($filter, 'ticket');

if ($tickets->totalItems === 0) {
    echo 'ERROR_NOT_FOUND';
    die();
}
$ticket = $tickets->list[0];

// Check if the ticket is already validated
if ($ticket['isValidated'] === 1) {
    echo 'ERROR_ALREADY_VALIDATED;' . json_encode($ticket);
    die();
}

// Get the ticket as VoObject
$t = SystemDisk::objectGet($ticket['objectId'], 'ticket');

// Set ticket as validated
$t->propertySet('isValidated', 1);

$result = SystemDisk::objectSet(
    $t,
    'ticket', true,
    WebConfigurationBase::$DISK_WEB_ID);

if (!$result->state) {
    echo 'ERROR_SET_AS_VALIDATED;' . json_encode($ticket);
    die();
}

// Print the ticket
echo 'SUCCESS;' . json_encode($ticket);