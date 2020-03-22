<?php

// Get the params
$objectType = UtilsHttp::getParameterValue('objectType');
$showDisk = UtilsHttp::getParameterValue('showDisk');
$diskDefault = UtilsHttp::getParameterValue('diskDefault');
$showTextProperties = UtilsHttp::getParameterValue('showTextProperties');
$showPeriod = UtilsHttp::getParameterValue('showPeriod');

// Save or update the configuration to the database
$result = SystemManager::configurationFilterSet($objectType, WebConfigurationBase::$ROOT_ID, $showDisk, $diskDefault, $showTextProperties, $showPeriod);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationFilterSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}