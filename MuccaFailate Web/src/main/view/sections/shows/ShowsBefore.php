<?php

// Get the most recent 3 shows
$currentPage = UtilsHttp::getEncodedParam('page');

$filter = new VoSystemFilter();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setPageCurrent($currentPage);
$filter->setPageNumItems(4);
$filter->setSortFields('time', 'DESC');

$shows = SystemDisk::objectsGet($filter, 'show');


// Generate meta description
$metaDescription = '';

foreach ($shows->list as $s) {
    $metaDescription .= $s['title'] . ' ' . $s['place'] . ' ' . $s['city'] . ' ' . $s['sDescription'] . ' ';
}


if ($metaDescription != '') {
    self::addMetaDescription(substr($metaDescription, 0, -1));
}