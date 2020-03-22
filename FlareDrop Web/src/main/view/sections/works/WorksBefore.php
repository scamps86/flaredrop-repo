<?php

// Get last 6 works
$filter = new VoSystemFilter();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setRandom();

$works = SystemDisk::objectsGet($filter, 'Work');


// Meta tags
$metaDescription = '';

foreach ($works->list as $w) {
    $metaDescription .= $w['title'] . ' ';
}

self::addMetaDescription(substr($metaDescription, 0, -1));