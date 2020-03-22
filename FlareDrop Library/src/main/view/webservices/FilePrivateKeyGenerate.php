<?php

// Get the requested file id
$fileId = UtilsHttp::getParameterValue('fileId');

// Do the login for the manager users
$session = SystemUsers::login();

// Get logged user data
$userData = $session->data;

// Generate a date for the next minute
$date = UtilsDate::operate('MINUTE', UtilsDate::create(), 1);

// Generate the private validation key
$key = SystemDisk::filePrivateKeyGenerate($fileId, $userData->userId, $date);

// Generate headers and print
UtilsHttp::fileGenerateHeaders('text/plain', strlen($key), 'filePrivateKeyGenerate', false);

echo $key;