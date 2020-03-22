<?php

// Get the parameters
$folderId = UtilsHttp::getParameterValue('folderId');
$objectType = UtilsHttp::getParameterValue('objectType');
$diskId = UtilsHttp::getParameterValue('diskId');

// Remove the folders from the database
$result = SystemDisk::folderRemove($folderId, $objectType);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'folderRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}