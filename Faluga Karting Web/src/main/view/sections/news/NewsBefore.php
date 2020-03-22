<?php

// Get the current page
$currentPage = UtilsHttp::getEncodedParam('page');

// Define the news filter
$filter = new VoSystemFilter();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setPageCurrent($currentPage);
$filter->setPageNumItems(6);

// Get the news
$news = SystemDisk::objectsGet($filter, 'new');

// Define the meta description
$metaDescription = '';

foreach ($news->list as $n) {
    $metaDescription .= $n['title'] . ' ';
}

self::addMetaDescription(substr($metaDescription, 0, -1));