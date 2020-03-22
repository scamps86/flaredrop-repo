<?php

// Define the filter
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setSortFields('creationDate', 'DESC');

// Get the presentations list
$presentations = SystemDisk::objectsGet($filter, 'presentation');

// Define  filter and
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setAND();
$filter->setPropertyMatch('showHome', '1');
$filter->setRandom();
$filter->setPageCurrent(0);
$filter->setPageNumItems(4);

// Get the products list
$products = SystemDisk::objectsGet($filter, 'product');

// Set meta tags
$metaDescription = '';

foreach ($presentations->list as $p) {
    $metaDescription .= $p['title'] . ' ';
}

self::addMetaDescription($metaDescription);