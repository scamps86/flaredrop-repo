<?php

// Get the params
$objectType = UtilsHttp::getParameterValue('objectType');

// Remove the object configuration from the database
$result = SystemManager::configurationObjectRemove($objectType);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationObjectRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}