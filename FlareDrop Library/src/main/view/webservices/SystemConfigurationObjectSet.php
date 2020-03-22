<?php

// Get the params
$objectType = UtilsHttp::getParameterValue('objectType');
$bundle = UtilsHttp::getParameterValue('bundle');
$foldersLink = UtilsHttp::getParameterValue('foldersLink');
$foldersShow = UtilsHttp::getParameterValue('foldersShow');
$folderOptionsShow = UtilsHttp::getParameterValue('folderOptionsShow');
$folderLevels = UtilsHttp::getParameterValue('folderLevels');
$folderFilesEnabled = UtilsHttp::getParameterValue('folderFilesEnabled');
$filesEnabled = UtilsHttp::getParameterValue('filesEnabled');
$folderPicturesEnabled = UtilsHttp::getParameterValue('folderPicturesEnabled');
$picturesEnabled = UtilsHttp::getParameterValue('picturesEnabled');
$pictureDimensions = UtilsHttp::getParameterValue('pictureDimensions');
$pictureQuality = UtilsHttp::getParameterValue('pictureQuality');

// Save or update the configuration to the database
$result = SystemManager::configurationObjectSet($objectType, WebConfigurationBase::$ROOT_ID, $bundle, $foldersLink, $foldersShow, $folderOptionsShow, $folderLevels, $folderFilesEnabled, $filesEnabled, $folderPicturesEnabled, $picturesEnabled, $pictureDimensions, $pictureQuality);

UtilsHttp::fileGenerateHeaders('text/plain', strlen($result->description), 'systemConfigurationObjectSet', false);

// Validate the result
if (!$result->state) {
    echo $result->description;
}