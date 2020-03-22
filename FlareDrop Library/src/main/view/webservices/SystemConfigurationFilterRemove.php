<?php

// Get the params
$objectType = UtilsHttp::getParameterValue('objectType');

// Remove the filter configuration from the database
$result = SystemManager::configurationFilterRemove($objectType);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationFilterRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}