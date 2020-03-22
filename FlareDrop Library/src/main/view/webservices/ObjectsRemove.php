<?php

// Get the parameters
$ids = UtilsHttp::getParameterValue('ids');
$objectType = UtilsHttp::getParameterValue('objectType');

// Get the ids array
$ids = json_decode($ids);

// Define the result
$result = null;

// Remove the objects to the selected folder
if ($objectType == 'user') {
    $result = SystemUsers::remove($ids);
} else {
    $result = SystemDisk::objectsRemove($ids, $objectType);
}

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'objectsRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}