<?php

// Generate the news filter
$filter = new VoSystemFilter();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setPropertyMatch('visible', '1');

// Get the news list
$news = SystemDisk::objectsGet($filter, 'new');