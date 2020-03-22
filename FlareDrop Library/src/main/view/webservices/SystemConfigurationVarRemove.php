<?php

// Get the params
$variable = UtilsHttp::getParameterValue('variable');

// Remove the global variables configuration from the database
$result = SystemManager::configurationVarRemove($variable);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationVarRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}