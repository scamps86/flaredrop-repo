<?php

// Get the sold products
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setFolderId(WebConstants::ID_CATEGORY_SOLD);
$filter->setPageCurrent(UtilsHttp::getEncodedParam('page'));
$filter->setPageNumItems(6);

$products = SystemDisk::objectsGet($filter, 'product');

// Get the customers
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setPageCurrent(UtilsHttp::getEncodedParam('pageC'));
$filter->setPageNumItems(6);

$customers = SystemDisk::objectsGet($filter, 'customer');

// Get the presentations
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setFolderId(WebConstants::ID_CATEGORY_PRESENTATION_SOLD);

$presentations = SystemDisk::objectsGet($filter, 'presentation');

// Set meta tags
$metaDescription = '';

foreach ($products->list as $m) {
    $metaDescription .= $m['name'] . ' - ';
}

if ($metaDescription != '') {
    self::addMetaDescription(substr($metaDescription, 0, -3));
}