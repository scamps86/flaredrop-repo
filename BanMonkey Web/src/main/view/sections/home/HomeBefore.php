<?php

// Get the in auction products
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setFolderId(WebConstants::ID_CATEGORY_IN_AUCTION);
$filter->setSortFields('objectId', 'DESC');

$inAuctionProducts = SystemDisk::objectsGet($filter, 'product');


// Get the next products
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setFolderId(WebConstants::ID_CATEGORY_NEXT);
$filter->setSortFields('creationDate', 'ASC');
$filter->setPageCurrent(0);
$filter->setPageNumItems(6);

$nextProducts = SystemDisk::objectsGet($filter, 'product');


// Get the presentations
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setFolderId(WebConstants::ID_CATEGORY_PRESENTATION_HOME);

$presentations = SystemDisk::objectsGet($filter, 'presentation');


// Get the schedule presentations only if no auction products found
$schedules = null;

if ($inAuctionProducts->totalItems <= 0) {
    $filter = new VoSystemFilter();
    $filter->setLanTag(WebConstants::getLanTag());
    $filter->setAND();
    $filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
    $filter->setAND();
    $filter->setRootId(WebConfigurationBase::$ROOT_ID);
    $filter->setAND();
    $filter->setFolderId(WebConstants::ID_CATEGORY_PRESENTATION_SCHEDULE);

    $schedules = SystemDisk::objectsGet($filter, 'presentation');
}


// Set meta tags
$metaDescription = '';

foreach ($inAuctionProducts->list as $m) {
    $metaDescription .= $m['name'] . ' - ';
}

if ($metaDescription != '') {
    self::addMetaDescription(substr($metaDescription, 0, -3));
}

// Testing
//include PATH_CONTROLLER.'testing/GenerateSchedules.php';