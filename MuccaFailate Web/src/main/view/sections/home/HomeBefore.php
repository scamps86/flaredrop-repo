<?php

// Get the most recent 3 shows
$filter = new VoSystemFilter();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setPageCurrent(0);
$filter->setPageNumItems(2);
$filter->setSortFields('time', 'ASC');

$shows = SystemDisk::objectsGet($filter, 'show');


// Get the news
$filter = new VoSystemFilter();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setPropertyMatch('visible', '1');

$news = SystemDisk::objectsGet($filter, 'new');


// Generate meta description
$metaDescription = '';

foreach ($news->list as $m) {
    $metaDescription .= $m['title'] . ' - ';
}


if ($metaDescription != '') {
    self::addMetaDescription(substr($metaDescription, 0, -3));
}