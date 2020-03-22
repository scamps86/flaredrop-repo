<?php

// Get the params
$propertiesConfigurationId = UtilsHttp::getParameterValue('propertiesConfigurationId');

// Remove the property configuration from the database
$result = SystemManager::configurationPropertyRemove($propertiesConfigurationId);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationPropertyRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}