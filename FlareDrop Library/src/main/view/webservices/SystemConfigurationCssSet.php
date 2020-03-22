<?php

// Get the params
$cssConfigurationId = UtilsHttp::getParameterValue('cssConfigurationId');
$name = UtilsHttp::getParameterValue('name');
$selector = UtilsHttp::getParameterValue('selector');
$styles = UtilsHttp::getParameterValue('styles');

// Save or update the configuration to the database
$result = SystemManager::configurationCssSet($cssConfigurationId, WebConfigurationBase::$ROOT_ID, $name, $selector, $styles);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationCssSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}