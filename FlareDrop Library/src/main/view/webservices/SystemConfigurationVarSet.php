<?php

// Get the params
$variable = UtilsHttp::getParameterValue('variable');
$name = UtilsHttp::getParameterValue('name');
$value = UtilsHttp::getParameterValue('value');

// Save or update the configuration to the database
$result = SystemManager::configurationVarSet($variable, WebConfigurationBase::$ROOT_ID, $name, $value);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationVarSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}