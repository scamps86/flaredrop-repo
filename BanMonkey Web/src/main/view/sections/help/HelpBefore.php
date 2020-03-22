<?php

// Get the presentations
$filter = new VoSystemFilter();
$filter->setLanTag(WebConstants::getLanTag());
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setFolderId(WebConstants::ID_CATEGORY_PRESENTATION_HELP);

$presentations = SystemDisk::objectsGet($filter, 'presentation');