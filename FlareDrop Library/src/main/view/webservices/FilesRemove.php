<?php

// Get the parameters
$fileIds = json_decode(UtilsHttp::getParameterValue('fileIds'));

// Remove the pictures
$result = SystemDisk::filesRemove($fileIds);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'filesRemove', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}