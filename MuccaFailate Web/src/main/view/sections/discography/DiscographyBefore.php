<?php

// Get the songs
$albumId = UtilsHttp::getEncodedParam('a');
$albumId = $albumId === '' ? WebConstants::MAIN_ALBUM_ID : $albumId;

$songs = null;

if ($albumId !== '') {
    $filter = new VoSystemFilter();
    $filter->setRootId(WebConfigurationBase::$ROOT_ID);
    $filter->setAND();
    $filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
    $filter->setAND();
    $filter->setLanTag(WebConstants::getLanTag());
    $filter->setAND();
    $filter->setPropertyMatch('visible', '1');
    $filter->setAND();
    $filter->setFolderId($albumId);
    $filter->setSortFields('index', 'ASC');

    $songs = SystemDisk::objectsGet($filter, 'album');
}

// Get the albums
$albums = SystemDisk::foldersGet(WebConfigurationBase::$ROOT_ID, 'album', WebConfigurationBase::$DISK_WEB_ID, true, WebConstants::getLanTag());

// Get the selected album
$album = SystemDisk::folderGet($albumId, 'album');

// Get the album zip file
$albumZip = UtilsDiskObject::firstFileGet($album->files);

// Generate meta description
$metaDescription = '';


foreach ($albums as $a) {
    $metaDescription .= $a['name'] . ' - ';
}


if ($metaDescription != '') {
    self::addMetaDescription(substr($metaDescription, 0, -3));
}