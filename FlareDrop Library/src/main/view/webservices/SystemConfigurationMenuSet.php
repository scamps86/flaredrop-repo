<?php

// Get the params
$objectType = UtilsHttp::getParameterValue('objectType');
$literalKey = UtilsHttp::getParameterValue('literalKey');
$iconClassName = UtilsHttp::getParameterValue('iconClassName');

// Save or update the configuration to the database
$result = SystemManager::configurationMenuSet($objectType, WebConfigurationBase::$ROOT_ID, $literalKey, $iconClassName);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationMenuSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}