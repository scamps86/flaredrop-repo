<?php

// Get the folders list
$folders = SystemDisk::foldersGet(WebConfigurationBase::$ROOT_ID, 'product', WebConfigurationBase::$DISK_WEB_ID, true, WebConstants::getLanTag());

// Get the selected folder
$folder = SystemDisk::folderGet(UtilsHttp::getEncodedParam('folderId'), 'product');

// Define the filter
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);

if ($folder != null) {
    $filter->setAND();
    $filter->setFolderId(UtilsHttp::getEncodedParam('folderId'));
}

$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setPageCurrent(0);
$filter->setPageNumItems(12);

// Get the products
$products = SystemDisk::objectsGet($filter, 'product');

// Set meta tags
$metaDescription = '';

foreach ($products->list as $p) {
    $metaDescription .= $p['title'] . ' ';
}

self::addMetaDescription($metaDescription);