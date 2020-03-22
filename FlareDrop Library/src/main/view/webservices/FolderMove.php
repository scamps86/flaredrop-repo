<?php

// Get the data from the POST parameters
$sourceFolderId = UtilsHttp::getParameterValue('sourceFolderId');
$destinationFolderId = UtilsHttp::getParameterValue('destinationFolderId');
$objectType = UtilsHttp::getParameterValue('objectType');

// Update the folder sorting priorities
$result = SystemDisk::folderMove($sourceFolderId, $destinationFolderId, $objectType);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'folderMove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}