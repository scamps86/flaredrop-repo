<?php

// Get the file id param
$fileId = UtilsHttp::getEncodedParam('fileId');

// Get the file validation key param (not necessary for non private files)
$validationKey = UtilsHttp::getEncodedParam('validationKey');

// Get the picture dimensions (not necessary for non picture files)
$dimensions = UtilsHttp::getEncodedParam('dimensions');

// Print the file
SystemDisk::filePrint($fileId, $validationKey, $dimensions);
