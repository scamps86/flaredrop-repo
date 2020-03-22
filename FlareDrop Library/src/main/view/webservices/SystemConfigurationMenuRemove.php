<?php

// Get the params
$objectType = UtilsHttp::getParameterValue('objectType');

// Remove the menu configuration from the database
$result = SystemManager::configurationMenuRemove($objectType);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationMenuRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}