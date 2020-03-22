<?php

// Get the params
$listConfigurationId = UtilsHttp::getParameterValue('listConfigurationId');
$objectType = UtilsHttp::getParameterValue('objectType');
$property = UtilsHttp::getParameterValue('property');
$literalKey = UtilsHttp::getParameterValue('literalKey');
$formatType = UtilsHttp::getParameterValue('formatType');
$width = UtilsHttp::getParameterValue('width');

// Save or update the configuration to the database
$result = SystemManager::configurationListSet($listConfigurationId, WebConfigurationBase::$ROOT_ID, $objectType, $property, $literalKey, $formatType, $width);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationListSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}