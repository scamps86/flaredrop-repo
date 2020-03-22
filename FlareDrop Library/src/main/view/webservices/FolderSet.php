<?php

// Get the params
$folderData = json_decode(UtilsHttp::getParameterValue('folderData'), true);

// Create the folder class
$folder = new VoFolder();
$folder = UtilsArray::arrayToClass($folderData, $folder);

// Set the root id
$folder->rootId = WebConfigurationBase::$ROOT_ID;

// Fill the folder literals
$lans = [];

foreach ($folder->literals as $l) {
    $lan = new VoFolderLan();
    $lan = UtilsArray::arrayToClass($l, $lan);
    array_push($lans, $lan);
}

$folder->literals = $lans;

// Save the folder data to the database
$result = SystemDisk::folderSet($folder);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'folderSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}