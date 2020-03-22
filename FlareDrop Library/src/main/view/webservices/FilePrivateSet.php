<?php

// Do the login for the manager users
SystemUsers::login();

// Get the params
$fileId = UtilsHttp::getParameterValue('fileId');
$isPrivate = UtilsHttp::getParameterValue('isPrivate');

// Parse isPrivate to a boolean
$isPrivate = $isPrivate == 'true';

// Set the file as private or not
$result = SystemDisk::filePrivateSet($fileId, $isPrivate);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'filePrivateSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}