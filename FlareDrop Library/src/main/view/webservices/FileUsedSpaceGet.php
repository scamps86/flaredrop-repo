<?php

// Get parameters
$type = UtilsHttp::getParameterValue('type');

// Print the files used space
$json = json_encode(SystemDisk::fileUsedSpaceGet($type));
UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'fileUsedSpaceGet', false);

echo $json;