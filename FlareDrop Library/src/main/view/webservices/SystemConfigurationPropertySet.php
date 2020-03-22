<?php

// Get the params
$propertiesConfigurationId = UtilsHttp::getParameterValue('propertiesConfigurationId');
$objectType = UtilsHttp::getParameterValue('objectType');
$property = UtilsHttp::getParameterValue('property');
$defaultValue = UtilsHttp::getParameterValue('defaultValue');
$literalKey = UtilsHttp::getParameterValue('literalKey');
$type = UtilsHttp::getParameterValue('type');
$localized = UtilsHttp::getParameterValue('localized');
$base64Encode = UtilsHttp::getParameterValue('base64Encode');
$validate = UtilsHttp::getParameterValue('validate');
$validateCondition = UtilsHttp::getParameterValue('validateCondition');
$validateErrorLiteralKey = UtilsHttp::getParameterValue('validateErrorLiteralKey');

// Save or update the configuration to the database
$result = SystemManager::configurationPropertySet($propertiesConfigurationId, WebConfigurationBase::$ROOT_ID, $objectType, $property, $defaultValue, $literalKey, $type, $localized, $base64Encode, $validate, $validateCondition, $validateErrorLiteralKey);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationPropertySet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}