<?php

// Generate the downloads filter
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setPropertyMatch('visible', '1');

// Get the news list
$downloads = SystemDisk::objectsGet($filter, 'download');