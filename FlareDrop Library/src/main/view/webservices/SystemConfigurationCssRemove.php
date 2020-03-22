<?php

// Get the params
$cssConfigurationId = UtilsHttp::getParameterValue('cssConfigurationId');

// Remove the CSS configuration from the database
$result = SystemManager::configurationCssRemove($cssConfigurationId);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationCssRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}