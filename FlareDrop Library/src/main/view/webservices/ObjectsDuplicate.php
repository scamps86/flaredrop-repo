<?php

// Get the parameters
$ids = UtilsHttp::getParameterValue('ids');
$folderId = UtilsHttp::getParameterValue('folderId');
$objectType = UtilsHttp::getParameterValue('objectType');

// Get the ids array
$ids = json_decode($ids);

// Define the result
$result = null;

// Duplicate the objects from the selected folder (NOT APLICABLE FOR USERS)
if ($objectType != 'user') {
    $result = SystemDisk::objectsDuplicate($ids, $folderId, $objectType);
}

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'objectsDuplicate', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}