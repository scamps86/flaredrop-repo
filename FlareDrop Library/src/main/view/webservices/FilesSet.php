<?php

// Get the params
$folderId = UtilsHttp::getParameterValue('folderId');
$objectId = UtilsHttp::getParameterValue('objectId');
$fileType = UtilsHttp::getParameterValue('fileType');

// Get the dimensions and quality (only for pictures)
$dimensions = UtilsHttp::getParameterValue('dimensions');
$quality = UtilsHttp::getParameterValue('quality');
$folderId = $folderId == '' ? -1 : $folderId;
$objectId = $objectId == '' ? -1 : $objectId;

if ($quality == '') {
    $quality = 0;
}

// Save the files to the database and the file system
$result = SystemDisk::filesSet($folderId, $objectId, $fileType, self::$_files, $dimensions, $quality);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'filesSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}