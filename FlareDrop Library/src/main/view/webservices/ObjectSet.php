<?php

// Get the params
$objectData = UtilsHttp::getParameterValue('objectData');
$objectType = UtilsHttp::getParameterValue('objectType');
$needValidation = UtilsHTTP::getParameterValue('needValidation');

// For users, if need the user to be auto-validated when creating it
$needValidation = $needValidation == 'true' ? true : false;

// Get the object data as a JSON
$objectData = json_decode($objectData, true);

// Define the result
$result = null;

// Set the user / object
if ($objectType == 'user') {
    $userData = UtilsArray::arrayToClass($objectData, new VoUser());
    $result = SystemUsers::set($userData, $needValidation);
} else {
    $objectData = UtilsArray::arrayToClass($objectData, new VoObject());
    $objectData->literals = UtilsArray::arrayToClassArray($objectData->literals, 'VoObjectLan');
    $result = SystemDisk::objectSet($objectData, $objectType);
}

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'objectSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}