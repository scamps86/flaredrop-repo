<?php

// Get the params
$listConfigurationId = UtilsHttp::getParameterValue('listConfigurationId');

// Remove the list configuration from the database
$result = SystemManager::configurationListRemove($listConfigurationId);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationListRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}