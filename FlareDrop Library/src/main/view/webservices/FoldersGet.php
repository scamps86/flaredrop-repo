<?php

// Get the necessary params
$lanTag = UtilsHttp::getParameterValue('lanTag');
$parentFolderId = UtilsHttp::getParameterValue('parentFolderId');
$diskId = UtilsHttp::getParameterValue('diskId');
$getVisible = UtilsHttp::getParameterValue('getVisible') == 'true';
$objectType = UtilsHttp::getParameterValue('objectType');

if ($parentFolderId == '') {
    $parentFolderId = null;
}

// Get the folders list
$categories = SystemDisk::foldersGet(WebConfigurationBase::$ROOT_ID, $objectType, $diskId, $getVisible, $lanTag, $parentFolderId);

// Return the categories as a JSON
$json = json_encode($categories);
UtilsHttp::fileGenerateHeaders('application/json', strlen($json), 'foldersGet', false);

echo $json;