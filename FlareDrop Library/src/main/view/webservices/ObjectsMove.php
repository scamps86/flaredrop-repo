<?php

// Get the parameters
$ids = UtilsHttp::getParameterValue('ids');
$folderIdFrom = UtilsHttp::getParameterValue('folderIdFrom');
$folderIdTo = UtilsHttp::getParameterValue('folderIdTo');
$objectType = UtilsHttp::getParameterValue('objectType');

// Get the ids array
$ids = json_decode($ids);

// Define the result
$result = null;

// Move the objects to the selected folder
if ($objectType == 'user') {
    $result = SystemUsers::move($ids, $folderIdFrom, $folderIdTo);
} else {
    $result = SystemDisk::objectsMove($ids, $folderIdFrom, $folderIdTo, $objectType);
}

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'objectsMove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}