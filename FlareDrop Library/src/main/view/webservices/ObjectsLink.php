<?php

// Get the parameters
$ids = UtilsHttp::getParameterValue('ids');
$folderId = UtilsHttp::getParameterValue('folderId');
$objectType = UtilsHttp::getParameterValue('objectType');

// Get the ids array
$ids = json_decode($ids);

// Define the result
$result = null;

// Move the objects to the selected folder
if ($objectType == 'user') {
    $result = SystemUsers::link($ids, $folderId);
} else {
    $result = SystemDisk::objectsLink($ids, $folderId, $objectType);
}

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'objectsLink', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}