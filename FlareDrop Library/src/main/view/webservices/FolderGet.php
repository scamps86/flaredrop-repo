<?php

// Get the parameters
$folderId = UtilsHttp::getParameterValue('folderId');
$objectType = UtilsHttp::getParameterValue('objectType');

// Get the folder data from database
$folder = SystemDisk::folderGet($folderId, $objectType);

// Print the folder as a JSON string
$json = json_encode($folder);
UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'folderGet', false);

echo $json;