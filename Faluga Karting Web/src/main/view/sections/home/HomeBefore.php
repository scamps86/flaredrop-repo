<?php

// Define the products filter
$filter = new VoSystemFilter();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setRandom();

// Get the products list
$products = SystemDisk::objectsGet($filter, 'productHome');

// Define the presentations filter
$filter = new VoSystemFilter();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setRandom();

// Get the presentation list
$presentations = SystemDisk::objectsGet($filter, 'presentation');

// Define the meta description
$metaDescription = Managers::literals()->get('META_DESCRIPTION', 'Home') . ' ';

foreach ($presentations->list as $p) {
    $metaDescription .= $p['title'] . ' ';
}

self::addMetaDescription(substr($metaDescription, 0, -1));
